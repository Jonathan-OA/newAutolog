<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVolumeStatusRequest;
use App\Http\Requests\UpdateVolumeStatusRequest;
use App\Repositories\VolumeStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class VolumeStatusController extends AppBaseController
{
    /** @var  VolumeStatusRepository */
    private $volumeStatusRepository;

    public function __construct(VolumeStatusRepository $volumeStatusRepo)
    {
        $this->volumeStatusRepository = $volumeStatusRepo;
    }

    /**
     * Display a listing of the VolumeStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->volumeStatusRepository->pushCriteria(new RequestCriteria($request));
        $volumeStatus = $this->volumeStatusRepository->all();

        return view('volume_status.index')
            ->with('volumeStatus', $volumeStatus);
    }

    /**
     * Show the form for creating a new VolumeStatus.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('volume_status_add',Auth::user()->user_type_code)){

            return view('volume_status.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('volume_status.index'));
        }
    }

    /**
     * Store a newly created VolumeStatus in storage.
     *
     * @param CreateVolumeStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateVolumeStatusRequest $request)
    {
        $input = $request->all();

        $volumeStatus = $this->volumeStatusRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('volumeStatus.index'));
    }

    /**
     * Display the specified VolumeStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $volumeStatus = $this->volumeStatusRepository->findWithoutFail($id);

        if (empty($volumeStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('volumeStatus.index'));
        }

        return view('volume_status.show')->with('volumeStatus', $volumeStatus);
    }

    /**
     * Show the form for editing the specified VolumeStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('volume_status_edit',Auth::user()->user_type_code)){

            $volumeStatus = $this->volumeStatusRepository->findWithoutFail($id);

            if (empty($volumeStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('volumeStatus.index'));
            }

            return view('volume_status.edit')->with('volumeStatus', $volumeStatus);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('volume_status.index'));
        }
    }

    /**
     * Update the specified VolumeStatus in storage.
     *
     * @param  int              $id
     * @param UpdateVolumeStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVolumeStatusRequest $request)
    {
        $volumeStatus = $this->volumeStatusRepository->findWithoutFail($id);

        if (empty($volumeStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('volumeStatus.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou VolumeStatus ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('volume_statusd_edit', $descricao);


        $volumeStatus = $this->volumeStatusRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('volumeStatus.index'));
    }

    /**
     * Remove the specified VolumeStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('volume_status_remove',Auth::user()->user_type_code)){
            
            $volumeStatus = $this->volumeStatusRepository->findWithoutFail($id);

            if (empty($volumeStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('volumeStatus.index'));
            }

            $this->volumeStatusRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu VolumeStatus ID: '.$id;
            $log = App\Models\Log::wlog('volume_status_remove', $descricao);


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
        return Datatables::of(App\Models\VolumeStatus::all())->make(true);
    }
}
