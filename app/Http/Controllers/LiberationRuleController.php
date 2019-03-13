<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLiberationRuleRequest;
use App\Http\Requests\UpdateLiberationRuleRequest;
use App\Repositories\LiberationRuleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Auth;
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
    public function index($moviment_code)
    {
        $liberationRules = $this->liberationRuleRepository->findWhere(array('moviment_code' => $moviment_code));

        return view('liberation_rules.index')
            ->with('liberationRules', $liberationRules)
            ->with('moviment_code', $moviment_code);
    }

    /**
     * Show the form for creating a new LiberationRule.
     *
     * @return Response
     */
    public function create($moviment_code)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('liberation_rules_add',Auth::user()->user_type_code)){

            return view('liberation_rules.create')->with('moviment_code', $moviment_code);;

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

        //Pega qual a model responsavel pelas regras de liberação do módulo
        $rc = App\Models\Moviment::getClass($request['moviment_code']);

        if($rc){
            //Movimento possui regras / class atrelada
            if(method_exists(new $rc['class'](),$input['code'])){
                //Regra foi encontrada no arquivo
                $liberationRule = $this->liberationRuleRepository->create($input);
                Flash::success(Lang::get('validation.save_success'));
                return redirect(url('liberationRules/idx/'.$liberationRule->moviment_code));
            }else{
                //Regra não existe no arquivo
                $msg = 'Regra '.$input['code'].' não existe no arquivo de liberação ('.$rc['class'].')';
                Flash::error($msg);
            }

        }else{
            $msg = 'Não foram encontradas regras para este movimento!';
            Flash::error($msg);
        }
        
        return redirect(url('liberationRules/create/'.$input['moviment_code']));
        
        
    }

    /**
     * Display the specified Packing.
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

            return redirect(url('liberationRules/idx/'.$liberationRule->moviment_code));
        }

        return view('liberationRules.show')->with('liberationRule', $liberationRule);
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
        $liberationRule = $this->liberationRuleRepository->findWithoutFail($id);
        
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('liberation_rules_edit',Auth::user()->user_type_code)){

            if (empty($liberationRule)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(url('liberationRules/idx/'.$liberationRule->moviment_code));
            }

            return view('liberation_rules.edit')->with('liberationRule', $liberationRule)
                                                ->with('moviment_code', $liberationRule->moviment_code);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('liberationRules/idx/'.$liberationRule->moviment_code));
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
        $log = App\Models\Log::wlog('liberation_items_edit', $descricao);


        $liberationRule = $this->liberationRuleRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(url('liberationRules/idx/'.$liberationRule->moviment_code));
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

                return redirect(url('liberationRules/idx/'.$liberationRule['moviment_code']));
            }

            $this->liberationRuleRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu liberationRule ID: '.$id.' - '.$liberationRule['code'];
            $log = App\Models\Log::wlog('liberation_rules_remove', $descricao);


            Flash::success(Lang::get('validation.delete_success'));
            return array('success',Lang::get('validation.delete_success'));

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return array('danger',Lang::get('validation.permission'));
        }    
    }

     /**
     * Get data from model 
     *
     */
    public function getData($moviment_code)
    {
        return Datatables::of(App\Models\LiberationRule::where('moviment_code', '=', $moviment_code))->make(true);
    }

}
