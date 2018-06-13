<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlockedProductRequest;
use App\Http\Requests\UpdateBlockedProductRequest;
use App\Repositories\BlockedProductRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class BlockedProductController extends AppBaseController
{
    /** @var  BlockedProductRepository */
    private $blockedProductRepository;

    public function __construct(BlockedProductRepository $blockedProductRepo)
    {
        $this->blockedProductRepository = $blockedProductRepo;
    }

    /**
     * Display a listing of the BlockedProduct.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->blockedProductRepository->pushCriteria(new RequestCriteria($request));
        $blockedProducts = $this->blockedProductRepository->all();

        return view('blocked_products.index')
            ->with('blockedProducts', $blockedProducts);
    }

    /**
     * Show the form for creating a new BlockedProduct.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_products_add',Auth::user()->user_type_code)){

            return view('blocked_products.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('blocked_products.index'));
        }
    }

    /**
     * Store a newly created BlockedProduct in storage.
     *
     * @param CreateBlockedProductRequest $request
     *
     * @return Response
     */
    public function store(CreateBlockedProductRequest $request)
    {
        $input = $request->all();

        $blockedProduct = $this->blockedProductRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('blockedProducts.index'));
    }

    /**
     * Display the specified BlockedProduct.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $blockedProduct = $this->blockedProductRepository->findWithoutFail($id);

        if (empty($blockedProduct)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('blockedProducts.index'));
        }

        return view('blocked_products.show')->with('blockedProduct', $blockedProduct);
    }

    /**
     * Show the form for editing the specified BlockedProduct.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_products_edit',Auth::user()->user_type_code)){

            $blockedProduct = $this->blockedProductRepository->findWithoutFail($id);

            if (empty($blockedProduct)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('blockedProducts.index'));
            }

            return view('blocked_products.edit')->with('blockedProduct', $blockedProduct);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('blocked_products.index'));
        }
    }

    /**
     * Update the specified BlockedProduct in storage.
     *
     * @param  int              $id
     * @param UpdateBlockedProductRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBlockedProductRequest $request)
    {
        $blockedProduct = $this->blockedProductRepository->findWithoutFail($id);

        if (empty($blockedProduct)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('blockedProducts.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou BlockedProduct ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('blocked_products_edit', $descricao);


        $blockedProduct = $this->blockedProductRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('blockedProducts.index'));
    }

    /**
     * Remove the specified BlockedProduct from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_products_remove',Auth::user()->user_type_code)){
            
            $blockedProduct = $this->blockedProductRepository->findWithoutFail($id);

            if (empty($blockedProduct)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('blockedProducts.index'));
            }

            $this->blockedProductRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu BlockedProduct ID: '.$id;
            $log = App\Models\Log::wlog('blocked_products_remove', $descricao);


            Flash::success(Lang::get('validation.delete_success'));
            return array(0,Lang::get('validation.delete_success'));

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return array(1,Lang::get('validation.permission'));
        }    
    }

    /**
     * Get data from model 
     *
     */
    public function getData()
    {
        return Datatables::of(App\Models\BlockedProduct::where('company_id', Auth::user()->company_id))->make(true);
    }
}
