<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Repositories\ActivityRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class ActivityController extends AppBaseController
{
    /** @var  ActivityRepository */
    private $activityRepository;

    public function __construct(ActivityRepository $activityRepo)
    {
        $this->activityRepository = $activityRepo;
    }

    /**
     * Display a listing of the Activity.
     *
     * @param $task_id
     * @return Response
     */
    public function index($task_id)
    {
        //Busca todas as atividades de uma tarefa
        $activities = $this->activityRepository
                           ->findWhere(array('task_id' => $task_id,
                                             'company_id' => Auth::user()->company_id));

        return view('activities.index')
            ->with('activities', $activities)
            ->with('taskId', $task_id);
    }

    /**
     * Show the form for creating a new Activity.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('activities_add',Auth::user()->user_type_code)){

            return view('activities.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('activities.index'));
        }
    }

    /**
     * Store a newly created Activity in storage.
     *
     * @param CreateActivityRequest $request
     *
     * @return Response
     */
    public function store(CreateActivityRequest $request)
    {
        $input = $request->all();

        $activity = $this->activityRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(action('ActivityController@index',[$activity['task_id']]));
    }

    /**
     * Display the specified Activity.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $activity = $this->activityRepository->findWithoutFail($id);

        if (empty($activity)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('activities.index'));
        }

        return view('activities.show')->with('activity', $activity);
    }

    /**
     * Show the form for editing the specified Activity.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('activities_edit',Auth::user()->user_type_code)){

            $activity = $this->activityRepository->findWithoutFail($id);

            if (empty($activity)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('activities.index'));
            }

            return view('activities.edit')->with('activity', $activity);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('activities.index'));
        }
    }

    /**
     * Update the specified Activity in storage.
     *
     * @param  int              $id
     * @param UpdateActivityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateActivityRequest $request)
    {
        $activity = $this->activityRepository->findWithoutFail($id);

        if (empty($activity)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('activities.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Atividade ID: '.$id.' - Etq: '.$requestF['label_id'].' - Pallet: '.$requestF['pallet_id'];
        $log = App\Models\Log::wlog('activities_edit', $descricao);


        $activity = $this->activityRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));
        return redirect(action('ActivityController@index',[$requestF['task_id']]));
    }

    /**
     * Remove the specified Activity from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('activities_remove',Auth::user()->user_type_code)){
            
            $activity = $this->activityRepository->findWithoutFail($id);

            if (empty($activity)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('activities.index'));
            }

            $this->activityRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Activity ID: '.$id;
            $log = App\Models\Log::wlog('activities_remove', $descricao);


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
    public function getData($task_id)
    {
        return DataTables::of(App\Models\Activity::getActivities($task_id))
                                                  ->make(true);
    }
}
