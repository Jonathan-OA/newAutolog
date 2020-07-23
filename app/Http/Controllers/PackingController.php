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
         //Load dos packings é feito por datatable no index.blade.php
        
        return view('packings.index')
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
            //Unidades de Medida
            $uoms = App\Models\Uom::getUoms();
            return view('packings.create')->with('product_code',$product_code)
                                          ->with('uoms',$uoms);

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

        //Id para retornar para a pagina do produto correto
        $product_code = $input['product_code'];

        Flash::success(Lang::get('validation.save_success'));

        return redirect(action('PackingController@index',[$product_code]));
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

            //Unidades de Medida
            $uoms = App\Models\Uom::getUoms();

            return view('packings.edit')->with('packing', $packing)
                                        ->with('uoms',$uoms)
                                        ->with('product_code',$packing->product_code);
        
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
        $descricao = 'Alterou Packing ID: '.$id.' - Prod:'.$requestF['product_code'].' Nivel: '.$requestF['level'].' Fat: '.$requestF['prev_qty'];
        $log = App\Models\Log::wlog('packings_edit', $descricao);


        $packing = $this->packingRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(action('PackingController@index',[$requestF['product_code']]));
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
     * Retorna todas as informações de uma embalagem / produto específicos
     *
     * @param  string $product_code,$uom_code
     *
     * @return Response
     */
    public function getLevel($product_code, $uom_code)
    {
        return App\Models\Packing::getLevel($product_code, $uom_code);

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
