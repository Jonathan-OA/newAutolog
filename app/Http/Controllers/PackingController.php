<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePackingRequest;
use App\Http\Requests\UpdatePackingRequest;
use App\Repositories\PackingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class PackingController extends AppBaseController
{
    /** @var  PackingRepository */
    private $packingRepository;

    public function __construct(PackingRepository $packingRepo)
    {
        $this->packingRepository = $packingRepo;
    }

    /**
     * Display a listing of the Packing.
     *
     * @param Request $request
     * @return Response
     */
    public function index($product_code)
    {
        $product = App\Models\Product::where('company_id', Auth::user()->company_id)
                            ->where('code', $product_code)
                            ->first();  

        $packings = $this->packingRepository->findWhere(array('product_code' => $product->code,
                                                              'company_id' => Auth::user()->company_id));

        return view('packings.index')
                ->with('packings', $packings)
                ->with('product_code', $product_code);
    }

    /**
     * Show the form for creating a new Packing.
     *
     * @return Response
     */
    public function create($product_code)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('packings_add',Auth::user()->user_type_code)){
            return view('packings.create')->with('product_code',$product_code);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('packings.index'));
        }
    }

    /**
     * Store a newly created Packing in storage.
     *
     * @param CreatePackingRequest $request
     *
     * @return Response
     */
    public function store(CreatePackingRequest $request)
    {
        $input = $request->all();

        $packing = $this->packingRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('packings.index'));
    }

    /**
     * Display the specified Packing.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $packing = $this->packingRepository->findWithoutFail($id);

        if (empty($packing)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('packings.index'));
        }

        return view('packings.show')->with('packing', $packing);
    }

    /**
     * Show the form for editing the specified Packing.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('packings_edit',Auth::user()->user_type_code)){

            $packing = $this->packingRepository->findWithoutFail($id);

            if (empty($packing)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('packings.index'));
            }

            return view('packings.edit')->with('packing', $packing);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('packings.index'));
        }
    }

    /**
     * Update the specified Packing in storage.
     *
     * @param  int              $id
     * @param UpdatePackingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePackingRequest $request)
    {
        $packing = $this->packingRepository->findWithoutFail($id);

        if (empty($packing)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('packings.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Packing ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('packings_edit', $descricao);


        $packing = $this->packingRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('packings.index'));
    }

    /**
     * Remove the specified Packing from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('packings_remove',Auth::user()->user_type_code)){
            
            $packing = $this->packingRepository->findWithoutFail($id);

            if (empty($packing)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('packings.index'));
            }

            $this->packingRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Packing ID: '.$id;
            $log = App\Models\Log::wlog('packings_remove', $descricao);


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
    public function getData($product_code)
    {
        return DataTables::of(App\Models\Packing::where('company_id', Auth::user()->company_id)
                                                  ->where('product_code', $product_code))
                                                  ->make(true);
    }
}
