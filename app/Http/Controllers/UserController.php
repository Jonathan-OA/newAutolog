<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;
use App\User;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->userRepository->findByField('company_id', Auth::user()->company_id);

        return view('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('users_add',Auth::user()->user_type_code)){
            //Lista usuários disponíveis
            $user_types = App\Models\UserType::getUserTypes();
            return view('users.create')->with('user_types', $user_types);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('users.index'));
        }

        
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = App\Models\User::create([
            'name' => $input['name'],
            'company_id' => $input['company_id'],
            'code' => $input['code'],
            'email' => $input['email'],
            'user_type_code' => $input['user_type_code'],
            'password' => bcrypt($input['password']),
            'last_login' => null,
            'status' => $input['status']
            
        ]);
        

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('users_edit',Auth::user()->user_type_code)){
            $user = $this->userRepository->findWithoutFail($id);
            //Lista usuários disponíveis
            $user_types = App\Models\UserType::getUserTypes();
    
            if (empty($user)) {
                Flash::error(Lang::get('validation.not_found'));
    
                return redirect(route('users.index'));
            }
    
            return view('users.edit')->with('user', $user)
                                     ->with('user_types', $user_types);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('users.index'));
        }

       
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('users.index'));
        }

        //Criptografa senha
        $campos = $request->all();
        $campos['password'] = bcrypt($campos['password']);

        $user = $this->userRepository->update($campos, $id);

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Usuário: '.$requestF['code'].' - Email: '.$requestF['email'].' - Tipo:'.$requestF['user_type_code'].' - Status: '.$requestF['status'];
        $log = App\Models\Log::wlog('users_edit', $descricao);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('users_remove',Auth::user()->user_type_code)){
            $user = $this->userRepository->findWithoutFail($id);

            if (empty($user)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('users.index'));
            }

            $this->userRepository->delete($id);

            //Grava log
            $descricao = 'Excluiu Usuário ID: '.$id.' - Código: '.$user->code;
            $log = App\Models\Log::wlog('users_remove', $descricao);

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
        return DataTables::of(App\Models\User::where('company_id', Auth::user()->company_id))->make(true);
    }

    /**
     * Atualiza Horario de Login
     *
     */

    public function updTime(){
        $user = Auth::user();
        $res = $user->updateLogin();
    }
}
