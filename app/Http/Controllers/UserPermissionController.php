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
use Auth;

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
     * Store a newly created UserPermission in storage.
     *
     * @param CreateUserPermissionRequest $request
     *
     * @return Response
     */
    public function store(CreateUserPermissionRequest $request)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('user_permissions_add',Auth::user()->user_type_code)){
            $input = $request->all();
            $userType =  $input['user_type_code'];
            $permissions = $input['permissions'];

            //Deleta as permissões anteriores para o tipo de usuário
            $deletedRows = App\Models\UserPermission::where('user_type_code', $userType)->delete();
            

            //Loop para inserir das permissões
            foreach($permissions as $permission){
                $input['operation_code'] = $permission;
                $perm = $this->userPermissionRepository->create($input);
            }

            //Grava log
            $descricao = 'Alterou permissões - Tipo de usuário: '.$userType;
            $log = App\Models\Log::wlog('user_permissions_add', $descricao);

            Flash::success(Lang::get('validation.save_success'));
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
        }
        return redirect(route('userTypes.index'));
        
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
