<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Repositories\DepartmentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class DepartmentController extends AppBaseController
{
    /** @var  DepartmentRepository */
    private $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepository = $departmentRepo;
    }

    /**
     * Display a listing of the Department.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->departmentRepository->pushCriteria(new RequestCriteria($request));
        $departments = $this->departmentRepository->all();

        return view('departments.index')
            ->with('departments', $departments);
    }

    /**
     * Show the form for creating a new Department.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('departments_add',Auth::user()->user_type_code)){

            return view('departments.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('departments.index'));
        }
    }

    /**
     * Store a newly created Department in storage.
     *
     * @param CreateDepartmentRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartmentRequest $request)
    {
        $input = $request->all();

        $department = $this->departmentRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('departments.index'));
    }

    /**
     * Display the specified Department.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $department = $this->departmentRepository->findWithoutFail($id);

        if (empty($department)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('departments.index'));
        }

        return view('departments.show')->with('department', $department);
    }

    /**
     * Show the form for editing the specified Department.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('departments_edit',Auth::user()->user_type_code)){

            $department = $this->departmentRepository->findWithoutFail($id);

            if (empty($department)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('departments.index'));
            }

            return view('departments.edit')->with('department', $department);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('departments.index'));
        }
    }

    /**
     * Update the specified Department in storage.
     *
     * @param  int              $id
     * @param UpdateDepartmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartmentRequest $request)
    {
        $department = $this->departmentRepository->findWithoutFail($id);

        if (empty($department)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('departments.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Department ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('departments_edit', $descricao);


        $department = $this->departmentRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('departments.index'));
    }

    /**
     * Remove the specified Department from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('departments_remove',Auth::user()->user_type_code)){
            
            $department = $this->departmentRepository->findWithoutFail($id);

            if (empty($department)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('departments.index'));
            }

            $this->departmentRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Department ID: '.$id;
            $log = App\Models\Log::wlog('departments_remove', $descricao);


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
        return Datatables::of(App\Models\Department::where('company_id', Auth::user()->company_id))->make(true);
    }
}
