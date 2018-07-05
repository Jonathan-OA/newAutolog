<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlockedOperationRequest;
use App\Http\Requests\UpdateBlockedOperationRequest;
use App\Repositories\BlockedOperationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class BlockedOperationController extends AppBaseController
{
    /** @var  BlockedOperationRepository */
    private $blockedOperationRepository;

    public function __construct(BlockedOperationRepository $blockedOperationRepo)
    {
        $this->blockedOperationRepository = $blockedOperationRepo;
    }

    /**
     * Display a listing of the BlockedOperation.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->blockedOperationRepository->pushCriteria(new RequestCriteria($request));
        $blockedOperations = $this->blockedOperationRepository->all();

        return view('blocked_operations.index')
            ->with('blockedOperations', $blockedOperations);
    }

    /**
     * Show the form for creating a new BlockedOperation.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_operations_add',Auth::user()->user_type_code)){

            return view('blocked_operations.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('blocked_operations.index'));
        }
    }

    /**
     * Store a newly created BlockedOperation in storage.
     *
     * @param CreateBlockedOperationRequest $request
     *
     * @return Response
     */
    public function store(CreateBlockedOperationRequest $request)
    {
        $input = $request->all();

        $blockedOperation = $this->blockedOperationRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('blockedOperations.index'));
    }

    /**
     * Display the specified BlockedOperation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $blockedOperation = $this->blockedOperationRepository->findWithoutFail($id);

        if (empty($blockedOperation)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('blockedOperations.index'));
        }

        return view('blocked_operations.show')->with('blockedOperation', $blockedOperation);
    }

    /**
     * Show the form for editing the specified BlockedOperation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_operations_edit',Auth::user()->user_type_code)){

            $blockedOperation = $this->blockedOperationRepository->findWithoutFail($id);

            if (empty($blockedOperation)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('blockedOperations.index'));
            }

            return view('blocked_operations.edit')->with('blockedOperation', $blockedOperation);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('blocked_operations.index'));
        }
    }

    /**
     * Update the specified BlockedOperation in storage.
     *
     * @param  int              $id
     * @param UpdateBlockedOperationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBlockedOperationRequest $request)
    {
        $blockedOperation = $this->blockedOperationRepository->findWithoutFail($id);

        if (empty($blockedOperation)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('blockedOperations.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou BlockedOperation ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('blocked_operations_edit', $descricao);


        $blockedOperation = $this->blockedOperationRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('blockedOperations.index'));
    }

    /**
     * Remove the specified BlockedOperation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_operations_remove',Auth::user()->user_type_code)){
            
            $blockedOperation = $this->blockedOperationRepository->findWithoutFail($id);

            if (empty($blockedOperation)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('blockedOperations.index'));
            }

            $this->blockedOperationRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu BlockedOperation ID: '.$id;
            $log = App\Models\Log::wlog('blocked_operations_remove', $descricao);


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
        return Datatables::of(App\Models\BlockedOperation::where('company_id', Auth::user()->company_id))->make(true);
    }
}
