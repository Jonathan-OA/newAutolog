<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlockedGroupRequest;
use App\Http\Requests\UpdateBlockedGroupRequest;
use App\Repositories\BlockedGroupRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class BlockedGroupController extends AppBaseController
{
    /** @var  BlockedGroupRepository */
    private $blockedGroupRepository;

    public function __construct(BlockedGroupRepository $blockedGroupRepo)
    {
        $this->blockedGroupRepository = $blockedGroupRepo;
    }

    /**
     * Display a listing of the BlockedGroup.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->blockedGroupRepository->pushCriteria(new RequestCriteria($request));
        $blockedGroups = $this->blockedGroupRepository->all();

        return view('products.blocked_groups.index')
            ->with('blockedGroups', $blockedGroups);
    }

    /**
     * Show the form for creating a new BlockedGroup.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_groups_add',Auth::user()->user_type_code)){

            return view('products.blocked_groups.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('blocked_groups.index'));
        }
    }

    /**
     * Store a newly created BlockedGroup in storage.
     *
     * @param CreateBlockedGroupRequest $request
     *
     * @return Response
     */
    public function store(CreateBlockedGroupRequest $request)
    {
        $input = $request->all();

        $blockedGroup = $this->blockedGroupRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('blockedGroups.index'));
    }

    /**
     * Display the specified BlockedGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $blockedGroup = $this->blockedGroupRepository->findWithoutFail($id);

        if (empty($blockedGroup)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('blockedGroups.index'));
        }

        return view('products.blocked_groups.show')->with('blockedGroup', $blockedGroup);
    }

    /**
     * Show the form for editing the specified BlockedGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_groups_edit',Auth::user()->user_type_code)){

            $blockedGroup = $this->blockedGroupRepository->findWithoutFail($id);

            if (empty($blockedGroup)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('blockedGroups.index'));
            }

            return view('products.blocked_groups.edit')->with('blockedGroup', $blockedGroup);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('blocked_groups.index'));
        }
    }

    /**
     * Update the specified BlockedGroup in storage.
     *
     * @param  int              $id
     * @param UpdateBlockedGroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBlockedGroupRequest $request)
    {
        $blockedGroup = $this->blockedGroupRepository->findWithoutFail($id);

        if (empty($blockedGroup)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('blockedGroups.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou BlockedGroup ID: '.$id.' - Group: '.$requestF['group_code'].' Setor: '.$requestF['sector_code'];
        $log = App\Models\Log::wlog('blocked_groups_edit', $descricao);


        $blockedGroup = $this->blockedGroupRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('blockedGroups.index'));
    }

    /**
     * Remove the specified BlockedGroup from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_groups_remove',Auth::user()->user_type_code)){
            
            $blockedGroup = $this->blockedGroupRepository->findWithoutFail($id);

            if (empty($blockedGroup)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('blockedGroups.index'));
            }

            $this->blockedGroupRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu BlockedGroup ID: '.$id;
            $log = App\Models\Log::wlog('blocked_groups_remove', $descricao);


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
        return Datatables::of(App\Models\BlockedGroup::where('company_id', Auth::user()->company_id))->make(true);
    }
}
