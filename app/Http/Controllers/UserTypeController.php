<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserTypeRequest;
use App\Http\Requests\UpdateUserTypeRequest;
use App\Repositories\UserTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;
use Auth;

class UserTypeController extends AppBaseController
{
    /** @var  UserTypeRepository */
    private $userTypeRepository;

    public function __construct(UserTypeRepository $userTypeRepo)
    {
        $this->userTypeRepository = $userTypeRepo;
    }

    /**
     * Display a listing of the UserType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userTypeRepository->pushCriteria(new RequestCriteria($request));
        $userTypes = $this->userTypeRepository->all();

        return view('users.user_types.index')
            ->with('userTypes', $userTypes);
    }

    /**
     * Show the form for creating a new UserType.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.user_types.create');
    }

    /**
     * Store a newly created UserType in storage.
     *
     * @param CreateUserTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateUserTypeRequest $request)
    {
        $input = $request->all();

        $userType = $this->userTypeRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('userTypes.index'));
    }

    /**
     * Display the specified UserType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userType = $this->userTypeRepository->findWithoutFail($id);

        if (empty($userType)) {
            Flash::error('User Type not found');

            return redirect(route('userTypes.index'));
        }

        return view('users.user_types.show')->with('userType', $userType);
    }

    /**
     * Show the form for editing the specified UserType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('user_types_edit',Auth::user()->user_type_code)){

            $userType = $this->userTypeRepository->findWithoutFail($id);

            if (empty($userType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('userTypes.index'));
            }


            return view('users.user_types.edit')->with('userType', $userType);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('userTypes.index'));
        }
    }

    /**
     * Update the specified UserType in storage.
     *
     * @param  int              $id
     * @param UpdateUserTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserTypeRequest $request)
    {
        $userType = $this->userTypeRepository->findWithoutFail($id);

        if (empty($userType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('userTypes.index'));
        }

        $userType = $this->userTypeRepository->update($request->all(), $id);
        
        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Tipo de Usuário ID: '.$id.' - '.$requestF['code'].' Status: '.$requestF['status'];
        $log = App\Models\Log::wlog('user_types_edit', $descricao);

        //Atualiza status de todos os usuários deste tipo de usuário
        $upd = App\Models\UserType::setStatusUsers($userType['code'],$userType['status']);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('userTypes.index'));
    }

    /**
     * Remove the specified UserType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('user_types_remove',Auth::user()->user_type_code)){
            
            $userType = $this->userTypeRepository->findWithoutFail($id);

            if (empty($userType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('userTypes.index'));
            }

            //Atualiza status de todos os usuários deste tipo de usuário
            $upd = App\Models\UserType::setStatusUsers($userType['code'],0);

            $this->userTypeRepository->delete($id);

            //Grava log
            $descricao = 'Excluiu Tipo de Usuário ID: '.$id.' - '.$userType['code'];
            $log = App\Models\Log::wlog('user_types_remove', $descricao);

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
        return DataTables::of(App\Models\UserType::query())->make(true);
    }
}
