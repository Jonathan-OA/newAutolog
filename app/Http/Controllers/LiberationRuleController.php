<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLiberationRuleRequest;
use App\Http\Requests\UpdateLiberationRuleRequest;
use App\Repositories\LiberationRuleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class LiberationRuleController extends AppBaseController
{
    /** @var  LiberationRuleRepository */
    private $liberationRuleRepository;

    public function __construct(LiberationRuleRepository $liberationRuleRepo)
    {
        $this->liberationRuleRepository = $liberationRuleRepo;
    }

    /**
     * Display a listing of the LiberationRule.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->liberationRuleRepository->pushCriteria(new RequestCriteria($request));
        $liberationRules = $this->liberationRuleRepository->findByField('company_id', Auth::user()->company_id);

        return view('liberation_rules.index')
            ->with('liberationRules', $liberationRules);
    }

    /**
     * Show the form for creating a new LiberationRule.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('liberation_rules_add',Auth::user()->user_type_code)){

            return view('liberation_rules.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('liberation_rules.index'));
        }
    }

    /**
     * Store a newly created LiberationRule in storage.
     *
     * @param CreateLiberationRuleRequest $request
     *
     * @return Response
     */
    public function store(CreateLiberationRuleRequest $request)
    {
        $input = $request->all();

        $liberationRule = $this->liberationRuleRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('liberationRules.index'));
    }

    /**
     * Display the specified LiberationRule.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $liberationRule = $this->liberationRuleRepository->findWithoutFail($id);

        if (empty($liberationRule)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('liberationRules.index'));
        }

        return view('liberation_rules.show')->with('liberationRule', $liberationRule);
    }

    /**
     * Show the form for editing the specified LiberationRule.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('liberation_rules_edit',Auth::user()->user_type_code)){

            $liberationRule = $this->liberationRuleRepository->findWithoutFail($id);

            if (empty($liberationRule)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('liberationRules.index'));
            }

            return view('liberation_rules.edit')->with('liberationRule', $liberationRule);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('liberation_rules.index'));
        }
    }

    /**
     * Update the specified LiberationRule in storage.
     *
     * @param  int              $id
     * @param UpdateLiberationRuleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLiberationRuleRequest $request)
    {
        $liberationRule = $this->liberationRuleRepository->findWithoutFail($id);

        if (empty($liberationRule)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('liberationRules.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou LiberationRule ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('liberation_rules_edit', $descricao);


        $liberationRule = $this->liberationRuleRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('liberationRules.index'));
    }

    /**
     * Remove the specified LiberationRule from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('liberation_rules_remove',Auth::user()->user_type_code)){
            
            $liberationRule = $this->liberationRuleRepository->findWithoutFail($id);

            if (empty($liberationRule)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('liberationRules.index'));
            }

            $this->liberationRuleRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu LiberationRule ID: '.$id;
            $log = App\Models\Log::wlog('liberation_rules_remove', $descricao);


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
        return Datatables::of(App\Models\LiberationRule::all())->make(true);
    }
}
