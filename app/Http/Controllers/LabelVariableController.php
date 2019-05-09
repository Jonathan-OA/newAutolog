<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLabelVariableRequest;
use App\Http\Requests\UpdateLabelVariableRequest;
use App\Repositories\LabelVariableRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;
use Schema;

class LabelVariableController extends AppBaseController
{
    /** @var  LabelVariableRepository */
    private $labelVariableRepository;

    public function __construct(LabelVariableRepository $labelVariableRepo)
    {
        $this->labelVariableRepository = $labelVariableRepo;
    }

    /**
     * Display a listing of the LabelVariable.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->labelVariableRepository->pushCriteria(new RequestCriteria($request));
        $labelVariables = $this->labelVariableRepository->all();

        return view('print.label_variables.index')
            ->with('labelVariables', $labelVariables);
    }

    /**
     * Show the form for creating a new LabelVariable.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_variables_add',Auth::user()->user_type_code)){

            return view('print.label_variables.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('label_variables.index'));
        }
    }

    /**
     * Store a newly created LabelVariable in storage.
     *
     * @param CreateLabelVariableRequest $request
     *
     * @return Response
     */
    public function store(CreateLabelVariableRequest $request)
    {
        


        $input = $request->all();

        //Valida se Tabela e Campo existem no Banco de Dados
        if(!Schema::hasTable($input['table'])){
            Flash::error('Tabela informada não existe no sistema.');
        }else if(!Schema::hasColumn($input['table'], $input['field'])) {
            Flash::error('Campo não encontrado na tabela informada.'); 
        }else{
            $labelVariable = $this->labelVariableRepository->create($input);
            Flash::success(Lang::get('validation.save_success'));
            return redirect(route('labelVariables.index'));
        }

        //Retorna para a tela de inputs sem perder os valores
        return redirect()->back()
                    ->withInput();
        
    }

    /**
     * Display the specified LabelVariable.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $labelVariable = $this->labelVariableRepository->findWithoutFail($id);

        if (empty($labelVariable)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('labelVariables.index'));
        }

        return view('print.label_variables.show')->with('labelVariable', $labelVariable);
    }

    /**
     * Show the form for editing the specified LabelVariable.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_variables_edit',Auth::user()->user_type_code)){

            $labelVariable = $this->labelVariableRepository->findWithoutFail($id);

            if (empty($labelVariable)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('labelVariables.index'));
            }

            return view('print.label_variables.edit')->with('labelVariable', $labelVariable);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('label_variables.index'));
        }
    }

    /**
     * Update the specified LabelVariable in storage.
     *
     * @param  int              $id
     * @param UpdateLabelVariableRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLabelVariableRequest $request)
    {
        $labelVariable = $this->labelVariableRepository->findWithoutFail($id);

        if (empty($labelVariable)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('labelVariables.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou LabelVariable ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('label_variables_edit', $descricao);


        $labelVariable = $this->labelVariableRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('labelVariables.index'));
    }

    /**
     * Remove the specified LabelVariable from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_variables_remove',Auth::user()->user_type_code)){
            
            $labelVariable = $this->labelVariableRepository->findWithoutFail($id);

            if (empty($labelVariable)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('labelVariables.index'));
            }

            $this->labelVariableRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu LabelVariable ID: '.$id;
            $log = App\Models\Log::wlog('label_variables_remove', $descricao);


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
        return Datatables::of(App\Models\LabelVariable::all())->make(true);
    }
}