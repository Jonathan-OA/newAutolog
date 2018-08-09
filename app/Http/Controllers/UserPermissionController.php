<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserPermissionRequest;
use App\Http\Requests\UpdateUserPermissionRequest;
use App\Repositories\UserPermissionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class UserPermissionController extends AppBaseController
{
    /** @var  UserPermissionRepository */
    private $userPermissionRepository;

    public function __construct(UserPermissionRepository $userPermissionRepo)
    {
        $this->userPermissionRepository = $userPermissionRepo;
    }

    /**
     * Display a listing of the UserPermission.
     *
     * @param Request $request
     * @return Response
     */
    public function index($user_type_code)
    {
        //Pega todas as operações cadastradas no sistema + permissões para este usuário
        $permissions = App\Models\UserPermission::getPermissions($user_type_code);
        //Pega as permissões cadastradas para o usuário
        $userPermissions = $this->userPermissionRepository->findWhere(['user_type_code' => $user_type_code]);   
        
        
        return view('users.user_permissions.index')
            ->with('permissions', $permissions)
            ->with('userPermissions', $userPermissions)
            ->with('userTypeCode',$user_type_code)
            ->with('moduleAnt', '') ;
    }

    /**
     * Show the form for creating a new UserPermission.
     *
     * @return Response
     */
    public function create()
    {
        $userTypes = App\Models\UserType::getUserTypes();
        $operations = App\Models\Operation::getOperations();
        return view('users.user_permissions.create')
               ->with('userTypes', $userTypes)
               ->with('operations', $operations);
    }

    /**
     * Store a newly created UserPermission in storage.
     *
     * @param CreateUserPermissionRequest $request
     *
     * @return Response
     */
    public function store(CreateUserPermissionRequest $request)
    {
        $input = $request->all();

        $userPermission = $this->userPermissionRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('userPermissions.index'));
    }

    /**
     * Display the specified UserPermission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userPermission = $this->userPermissionRepository->findWithoutFail($id);

        if (empty($userPermission)) {
            Flash::error('User Permission not found');

            return redirect(route('userPermissions.index'));
        }

        return view('users.user_permissions.show')->with('userPermission', $userPermission);
    }

    /**
     * Show the form for editing the specified UserPermission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userPermission = $this->userPermissionRepository->findWithoutFail($id);

        $userTypes = App\Models\UserType::getUserTypes();
        $operations = App\Models\Operation::getOperations();

        if (empty($userPermission)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('userPermissions.index'));
        }

        return view('users.user_permissions.edit')->with('userPermission', $userPermission)
                                            ->with('userTypes',$userTypes)
                                            ->with('operations',$operations);
    }

    /**
     * Update the specified UserPermission in storage.
     *
     * @param  int              $id
     * @param UpdateUserPermissionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserPermissionRequest $request)
    {
        $userPermission = $this->userPermissionRepository->findWithoutFail($id);

        if (empty($userPermission)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('userPermissions.index'));
        }

        $userPermission = $this->userPermissionRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('userPermissions.index'));
    }

    /**
     * Remove the specified UserPermission from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userPermission = $this->userPermissionRepository->findWithoutFail($id);

        if (empty($userPermission)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('userPermissions.index'));
        }

        $this->userPermissionRepository->delete($id);

        Flash::success(Lang::get('validation.delete_success'));

        return redirect(route('userPermissions.index'));
    }

    /**
     * Get data from model 
     *
     */
    public function getPermissions($user_type_code)
    {
        return App\Models\UserPermission::getPermissions($user_type_code);
    }
}
