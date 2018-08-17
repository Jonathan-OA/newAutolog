<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePalletStatusRequest;
use App\Http\Requests\UpdatePalletStatusRequest;
use App\Repositories\PalletStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class PalletStatusController extends AppBaseController
{
    /** @var  palletStatusRepository */
    private $palletStatusRepository;

    public function __construct(PalletStatusRepository $palletStatusRepo)
    {
        $this->palletStatusRepository = $palletStatusRepo;
    }

    /**
     * Display a listing of the palletStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->palletStatusRepository->pushCriteria(new RequestCriteria($request));
        $palletStatus = $this->palletStatusRepository->all();

        return view('pallet_status.index')
            ->with('palletStatus', $palletStatus);
    }

    /**
     * Show the form for creating a new palletStatus.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('pallet_status_add',Auth::user()->user_type_code)){

            return view('pallet_status.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('pallet_status.index'));
        }
    }

    /**
     * Store a newly created palletStatus in storage.
     *
     * @param CreatePalletStatusRequest $request
     *
     * @return Response
     */
    public function store(CreatePalletStatusRequest $request)
    {
        $input = $request->all();

        $palletStatus = $this->palletStatusRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('palletStatus.index'));
    }

    /**
     * Display the specified palletStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $palletStatus = $this->palletStatusRepository->findWithoutFail($id);

        if (empty($palletStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('palletStatus.index'));
        }

        return view('pallet_status.show')->with('palletStatus', $palletStatus);
    }

    /**
     * Show the form for editing the specified palletStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('pallet_status_edit',Auth::user()->user_type_code)){

            $palletStatus = $this->palletStatusRepository->findWithoutFail($id);

            if (empty($palletStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('palletStatus.index'));
            }

            return view('pallet_status.edit')->with('palletStatus', $palletStatus);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('pallet_status.index'));
        }
    }

    /**
     * Update the specified palletStatus in storage.
     *
     * @param  int              $id
     * @param UpdatepalletStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepalletStatusRequest $request)
    {
        $palletStatus = $this->palletStatusRepository->findWithoutFail($id);

        if (empty($palletStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('palletStatus.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou palletStatus ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('pallet_status_edit', $descricao);


        $palletStatus = $this->palletStatusRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('palletStatus.index'));
    }

    /**
     * Remove the specified palletStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('pallet_status_remove',Auth::user()->user_type_code)){
            
            $palletStatus = $this->palletStatusRepository->findWithoutFail($id);

            if (empty($palletStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('palletStatus.index'));
            }

            $this->palletStatusRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu palletStatus ID: '.$id;
            $log = App\Models\Log::wlog('pallet_status_remove', $descricao);


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
        return Datatables::of(App\Models\palletStatus::all())->make(true);
    }
}
