<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateActivityStatusRequest;
use App\Http\Requests\UpdateActivityStatusRequest;
use App\Repositories\ActivityStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class ActivityStatusController extends AppBaseController
{
    /** @var  ActivityStatusRepository */
    private $activityStatusRepository;

    public function __construct(ActivityStatusRepository $activityStatusRepo)
    {
        $this->activityStatusRepository = $activityStatusRepo;
    }

    /**
     * Display a listing of the ActivityStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->activityStatusRepository->pushCriteria(new RequestCriteria($request));
        $activityStatus = $this->activityStatusRepository->all();

        return view('activity_status.index')
            ->with('activityStatus', $activityStatus);
    }

    /**
     * Show the form for creating a new ActivityStatus.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('activity_status_add',Auth::user()->user_type_code)){

            return view('activity_status.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('activity_status.index'));
        }
    }

    /**
     * Store a newly created ActivityStatus in storage.
     *
     * @param CreateActivityStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateActivityStatusRequest $request)
    {
        $input = $request->all();

        $activityStatus = $this->activityStatusRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('activityStatus.index'));
    }

    /**
     * Display the specified ActivityStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $activityStatus = $this->activityStatusRepository->findWithoutFail($id);

        if (empty($activityStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('activityStatus.index'));
        }

        return view('activity_status.show')->with('activityStatus', $activityStatus);
    }

    /**
     * Show the form for editing the specified ActivityStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('activity_status_edit',Auth::user()->user_type_code)){

            $activityStatus = $this->activityStatusRepository->findWithoutFail($id);

            if (empty($activityStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('activityStatus.index'));
            }

            return view('activity_status.edit')->with('activityStatus', $activityStatus);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('activity_status.index'));
        }
    }

    /**
     * Update the specified ActivityStatus in storage.
     *
     * @param  int              $id
     * @param UpdateActivityStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateActivityStatusRequest $request)
    {
        $activityStatus = $this->activityStatusRepository->findWithoutFail($id);

        if (empty($activityStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('activityStatus.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou ActivityStatus ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('activity_status_edit', $descricao);


        $activityStatus = $this->activityStatusRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('activityStatus.index'));
    }

    /**
     * Remove the specified ActivityStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('activity_status_remove',Auth::user()->user_type_code)){
            
            $activityStatus = $this->activityStatusRepository->findWithoutFail($id);

            if (empty($activityStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('activityStatus.index'));
            }

            $this->activityStatusRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu ActivityStatus ID: '.$id;
            $log = App\Models\Log::wlog('activity_status_remove', $descricao);


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
        return Datatables::of(App\Models\ActivityStatus::all())->make(true);
    }
}
