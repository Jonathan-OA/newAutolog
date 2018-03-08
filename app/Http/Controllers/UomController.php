<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUomRequest;
use App\Http\Requests\UpdateUomRequest;
use App\Repositories\UomRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class UomController extends AppBaseController
{
    /** @var  UomRepository */
    private $uomRepository;

    public function __construct(UomRepository $uomRepo)
    {
        $this->uomRepository = $uomRepo;
    }

    /**
     * Display a listing of the Uom.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->uomRepository->pushCriteria(new RequestCriteria($request));
        $uoms = $this->uomRepository->all();

        return view('products.uoms.index')
            ->with('uoms', $uoms);
    }

    /**
     * Show the form for creating a new Uom.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('uoms_add',Auth::user()->user_type_code)){

            return view('products.uoms.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('uoms.index'));
        }
    }

    /**
     * Store a newly created Uom in storage.
     *
     * @param CreateUomRequest $request
     *
     * @return Response
     */
    public function store(CreateUomRequest $request)
    {
        $input = $request->all();

        $uom = $this->uomRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('uoms.index'));
    }

    /**
     * Display the specified Uom.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $uom = $this->uomRepository->findWithoutFail($id);

        if (empty($uom)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('uoms.index'));
        }

        return view('products.uoms.show')->with('uom', $uom);
    }

    /**
     * Show the form for editing the specified Uom.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('uoms_edit',Auth::user()->user_type_code)){

            $uom = $this->uomRepository->findWithoutFail($id);
            if (empty($uom)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('uoms.index'));
            }

            return view('products.uoms.edit')->with('uom', $uom);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('uoms.index'));
        }
    }

    /**
     * Update the specified Uom in storage.
     *
     * @param  int              $id
     * @param UpdateUomRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUomRequest $request)
    {
        $uom = $this->uomRepository->findWithoutFail($id);

        if (empty($uom)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('uoms.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Uom ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('uoms_edit', $descricao);


        $uom = $this->uomRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('uoms.index'));
    }

    /**
     * Remove the specified Uom from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('uoms_remove',Auth::user()->user_type_code)){
            
            $uom = $this->uomRepository->findWithoutFail($id);

            if (empty($uom)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('uoms.index'));
            }

            $this->uomRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Uom ID: '.$id;
            $log = App\Models\Log::wlog('uoms_remove', $descricao);


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
        return DataTables::of(App\Models\Uom::all())->make(true);
    }
}
