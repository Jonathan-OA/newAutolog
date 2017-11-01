<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOperationRequest;
use App\Http\Requests\UpdateOperationRequest;
use App\Repositories\OperationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class OperationController extends AppBaseController
{
    /** @var  OperationRepository */
    private $operationRepository;

    public function __construct(OperationRepository $operationRepo)
    {
        $this->operationRepository = $operationRepo;
    }

    /**
     * Display a listing of the Operation.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->operationRepository->pushCriteria(new RequestCriteria($request));
        $operations = $this->operationRepository->all();

        return view('operations.index')
            ->with('operations', $operations);
    }

    /**
     * Show the form for creating a new Operation.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('operacoes_incluir',Auth::user()->user_type_code)){
            //Lista de modulos disponíveis para inserção da operação
            $modules = App\Models\Module::getModules();
        
            return view('operations.create')->with('modules', $modules);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('operations.index'));
        }

        
        
    }

    /**
     * Store a newly created Operation in storage.
     *
     * @param CreateOperationRequest $request
     *
     * @return Response
     */
    public function store(CreateOperationRequest $request)
    {
        $input = $request->all();

        $operation = $this->operationRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('operations.index'));
    }

    /**
     * Display the specified Operation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $operation = $this->operationRepository->findWithoutFail($id);

        if (empty($operation)) {
            Flash::error('Operation not found');

            return redirect(route('operations.index'));
        }

        return view('operations.show')->with('operation', $operation);
    }

    /**
     * Show the form for editing the specified Operation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('operacoes_editar',Auth::user()->user_type_code)){
            $operation = $this->operationRepository->findWithoutFail($id);

            if (empty($operation)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('operations.index'));
            }

            //Lista de modulos disponíveis para inserção da operação
            $modules = App\Models\Module::getModules();

            return view('operations.edit')->with('modules', $modules)
                                        ->with('operation', $operation);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('operations.index'));
        }
                                      
    }

    /**
     * Update the specified Operation in storage.
     *
     * @param  int              $id
     * @param UpdateOperationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOperationRequest $request)
    {
        $operation = $this->operationRepository->findWithoutFail($id);

        if (empty($operation)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('operations.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Operação ID: '.$id.' - '.$requestF['description'];
        $log = App\Models\Log::wlog('operacoes_editar', $descricao);

        $operation = $this->operationRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('operations.index'));
    }

    /**
     * Remove the specified Operation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('operations_remove',Auth::user()->user_type_code)){
            $operation = $this->operationRepository->findWithoutFail($id);

            if (empty($operation)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('operations.index'));
            }

            $this->operationRepository->delete($id);

            //Grava log
            $descricao = 'Excluiu Operação ID: '.$id;
            $log = App\Models\Log::wlog('operations_remove', $descricao);

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
        return Datatables::of(App\Models\Operation::query())->make(true);
    }



}
