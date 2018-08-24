<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Repositories\TaskRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class TaskController extends AppBaseController
{
    /** @var  TaskRepository */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->taskRepository = $taskRepo;
    }

    /**
     * Display a listing of the Task.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->taskRepository->pushCriteria(new RequestCriteria($request));
        $tasks = $this->taskRepository->findByField('company_id', Auth::user()->company_id);

        return view('tasks.index')
            ->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new Task.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('tasks_add',Auth::user()->user_type_code)){
            $status = App\Models\TaskStatus::getTaskStatus();
            return view('tasks.create')->with('taskStatus', $status);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('tasks.index'));
        }
    }

    /**
     * Store a newly created Task in storage.
     *
     * @param CreateTaskRequest $request
     *
     * @return Response
     */
    public function store(CreateTaskRequest $request)
    {
        $input = $request->all();

        $task = $this->taskRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified Task.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $task = $this->taskRepository->findWithoutFail($id);

        if (empty($task)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('tasks.index'));
        }

        return view('tasks.show')->with('task', $task);
    }

    /**
     * Show the form for editing the specified Task.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('tasks_edit',Auth::user()->user_type_code)){

            $task = $this->taskRepository->findWithoutFail($id);

            if (empty($task)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('tasks.index'));
            }

            $status = App\Models\TaskStatus::getTaskStatus();

            return view('tasks.edit')->with('task', $task)
                                     ->with('taskStatus', $status);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('tasks.index'));
        }
    }

    /**
     * Update the specified Task in storage.
     *
     * @param  int              $id
     * @param UpdateTaskRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaskRequest $request)
    {
        $task = $this->taskRepository->findWithoutFail($id);

        if (empty($task)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('tasks.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Tarefa ID: '.$id.' - '.$requestF['operation_code'];
        $log = App\Models\Log::wlog('tasks_edit', $descricao);


        $task = $this->taskRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified Task from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('tasks_remove',Auth::user()->user_type_code)){
            
            $task = $this->taskRepository->findWithoutFail($id);

            if (empty($task)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('tasks.index'));
            }

            $this->taskRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Task ID: '.$id;
            $log = App\Models\Log::wlog('tasks_remove', $descricao);


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
        return Datatables::of(App\Models\Task::getTasks())->make(true);
    }
}
