<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductTypeRequest;
use App\Http\Requests\UpdateProductTypeRequest;
use App\Repositories\ProductTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class ProductTypeController extends AppBaseController
{
    /** @var  ProductTypeRepository */
    private $productTypeRepository;

    public function __construct(ProductTypeRepository $productTypeRepo)
    {
        $this->productTypeRepository = $productTypeRepo;
    }

    /**
     * Display a listing of the ProductType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->productTypeRepository->pushCriteria(new RequestCriteria($request));
        $productTypes = $this->productTypeRepository->all();

        return view('products.product_types.index')
            ->with('productTypes', $productTypes);
    }

    /**
     * Show the form for creating a new ProductType.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('product_types_add',Auth::user()->user_type_code)){

            return view('products.product_types.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('productTypes.index'));
        }
    }

    /**
     * Store a newly created ProductType in storage.
     *
     * @param CreateProductTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateProductTypeRequest $request)
    {
        $input = $request->all();

        $productType = $this->productTypeRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('productTypes.index'));
    }

    /**
     * Display the specified ProductType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productType = $this->productTypeRepository->findWithoutFail($id);

        if (empty($productType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('productTypes.index'));
        }

        return view('products.product_types.show')->with('productType', $productType);
    }

    /**
     * Show the form for editing the specified ProductType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('product_types_edit',Auth::user()->user_type_code)){

            $productType = $this->productTypeRepository->findWithoutFail($id);

            if (empty($productType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('productTypes.index'));
            }

            return view('products.product_types.edit')->with('productType', $productType);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('productTypes.index'));
        }
    }

    /**
     * Update the specified ProductType in storage.
     *
     * @param  int              $id
     * @param UpdateProductTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductTypeRequest $request)
    {
        $productType = $this->productTypeRepository->findWithoutFail($id);

        if (empty($productType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('productTypes.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou ProductType ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('product_types_edit', $descricao);


        $productType = $this->productTypeRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('productTypes.index'));
    }

    /**
     * Remove the specified ProductType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('product_types_remove',Auth::user()->user_type_code)){
            
            $productType = $this->productTypeRepository->findWithoutFail($id);

            if (empty($productType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('productTypes.index'));
            }

            $this->productTypeRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu ProductType ID: '.$id;
            $log = App\Models\Log::wlog('product_types_remove', $descricao);


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
        return DataTables::of(App\Models\ProductType::query())->make(true);
    }
}
