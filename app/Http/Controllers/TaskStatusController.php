<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Repositories\TaskStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class TaskStatusController extends AppBaseController
{
    /** @var  TaskStatusRepository */
    private $taskStatusRepository;

    public function __construct(TaskStatusRepository $taskStatusRepo)
    {
        $this->taskStatusRepository = $taskStatusRepo;
    }

    /**
     * Display a listing of the TaskStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->taskStatusRepository->pushCriteria(new RequestCriteria($request));
        $taskStatus = $this->taskStatusRepository->all();

        return view('task_status.index')
            ->with('taskStatus', $taskStatus);
    }

    /**
     * Show the form for creating a new TaskStatus.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('task_status_add',Auth::user()->user_type_code)){

            return view('task_status.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('task_status.index'));
        }
    }

    /**
     * Store a newly created TaskStatus in storage.
     *
     * @param CreateTaskStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateTaskStatusRequest $request)
    {
        $input = $request->all();

        $taskStatus = $this->taskStatusRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('taskStatus.index'));
    }

    /**
     * Display the specified TaskStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $taskStatus = $this->taskStatusRepository->findWithoutFail($id);

        if (empty($taskStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('taskStatus.index'));
        }

        return view('task_status.show')->with('taskStatus', $taskStatus);
    }

    /**
     * Show the form for editing the specified TaskStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('task_status_edit',Auth::user()->user_type_code)){

            $taskStatus = $this->taskStatusRepository->findWithoutFail($id);

            if (empty($taskStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('taskStatus.index'));
            }

            return view('task_status.edit')->with('taskStatus', $taskStatus);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('task_status.index'));
        }
    }

    /**
     * Update the specified TaskStatus in storage.
     *
     * @param  int              $id
     * @param UpdateTaskStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaskStatusRequest $request)
    {
        $taskStatus = $this->taskStatusRepository->findWithoutFail($id);

        if (empty($taskStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('taskStatus.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou TaskStatus ID: '.$id;
        $log = App\Models\Log::wlog('task_status_edit', $descricao);


        $taskStatus = $this->taskStatusRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('taskStatus.index'));
    }

    /**
     * Remove the specified TaskStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('task_status_remove',Auth::user()->user_type_code)){
            
            $taskStatus = $this->taskStatusRepository->findWithoutFail($id);

            if (empty($taskStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('taskStatus.index'));
            }

            $this->taskStatusRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu TaskStatus ID: '.$id;
            $log = App\Models\Log::wlog('task_status_remove', $descricao);


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
        return Datatables::of(App\Models\TaskStatus::all())->make(true);
    }
}
