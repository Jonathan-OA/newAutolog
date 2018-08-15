<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Repositories\GroupRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class GroupController extends AppBaseController
{
    /** @var  GroupRepository */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepo)
    {
        $this->groupRepository = $groupRepo;
    }

    /**
     * Display a listing of the Group.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->groupRepository->pushCriteria(new RequestCriteria($request));
        $groups = $this->groupRepository->findByField('company_id', Auth::user()->company_id);

        return view('products.groups.index')
            ->with('groups', $groups);
    }

    /**
     * Show the form for creating a new Group.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('groups_add',Auth::user()->user_type_code)){
            //Tipos de produtos para o droplist
            $prd_types = App\Models\ProductType::getProductTypes();
            
            return view('products.groups.create')->with('prd_types',$prd_types);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('groups.index'));
        }
    }

    /**
     * Store a newly created Group in storage.
     *
     * @param CreateGroupRequest $request
     *
     * @return Response
     */
    public function store(CreateGroupRequest $request)
    {
        $input = $request->all();

        $group = $this->groupRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('groups.index'));
    }

    /**
     * Display the specified Group.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $group = $this->groupRepository->findWithoutFail($id);

        if (empty($group)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('groups.index'));
        }

        return view('products.groups.show')->with('group', $group);
    }

    /**
     * Show the form for editing the specified Group.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('groups_edit',Auth::user()->user_type_code)){

            $group = $this->groupRepository->findWithoutFail($id);

            if (empty($group)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('groups.index'));
            }
            //Tipos de produtos para o droplist
            $prd_types = App\Models\ProductType::getProductTypes();

            return view('products.groups.edit')->with('group', $group)
                                      ->with('prd_types', $prd_types);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('groups.index'));
        }
    }

    /**
     * Update the specified Group in storage.
     *
     * @param  int              $id
     * @param UpdateGroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGroupRequest $request)
    {
        $group = $this->groupRepository->findWithoutFail($id);

        if (empty($group)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('groups.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Group ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('groups_edit', $descricao);


        $group = $this->groupRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('groups.index'));
    }

    /**
     * Remove the specified Group from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('groups_remove',Auth::user()->user_type_code)){
            
            $group = $this->groupRepository->findWithoutFail($id);

            if (empty($group)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('groups.index'));
            }

            $this->groupRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Group ID: '.$id;
            $log = App\Models\Log::wlog('groups_remove', $descricao);


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
        return DataTables::of(App\Models\Group::where('company_id', Auth::user()->company_id))->make(true);
    }
}
