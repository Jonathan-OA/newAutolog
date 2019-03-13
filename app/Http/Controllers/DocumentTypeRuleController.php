<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentTypeRuleRequest;
use App\Http\Requests\UpdateDocumentTypeRuleRequest;
use App\Repositories\DocumentTypeRuleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;
use DB;

class DocumentTypeRuleController extends AppBaseController
{
    /** @var  DocumentTypeRuleRepository */
    private $documentTypeRuleRepository;

    public function __construct(DocumentTypeRuleRepository $documentTypeRuleRepo)
    {
        $this->documentTypeRuleRepository = $documentTypeRuleRepo;
    }

    /**
     * Display a listing of the DocumentTypeRule.
     *
     * @param Request $request
     * @return Response
     */
    public function index($document_type_code)
    {
        //Pega tipo de movimento do tipo de documento
        $moviment = App\Models\DocumentType::getMoviment($document_type_code);
        //Pega todas as regras referentes aquele modulo (desconsiderando as já cadastradas)
        $rulesMov = App\Models\LiberationRule::getLiberationRules($moviment[0], $document_type_code);

        //Pega todas as regras cadastradas para aquele tipo de documento
        $documentTypeRules = App\Models\DocumentTypeRule::getDocumentTypeRules($document_type_code);  
        
        return view('document_type_rules.index')
            ->with('documentTypeRules', $documentTypeRules)
            ->with('rulesMov', $rulesMov)
            ->with('document_type_code', $document_type_code)
            ->with('moviment_code', $moviment[0]);
    }


    /**
     * Store a newly created DocumentTypeRule in storage.
     *
     * @param CreateDocumentTypeRuleRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentTypeRuleRequest $request)
    {
       
        $input = $request->all();
        //Assume company_id do usuário logado
        $input['company_id'] = Auth::user()->company_id;
        
        //Pega ultima regra e incrementa ordem + 1
        $input['order'] = App\Models\DocumentTypeRule::getOrder($input['document_type_code']);

        $documentTypeRule = $this->documentTypeRuleRepository->create($input);

        //Flash::success(Lang::get('validation.save_success'));
        return array('success',Lang::get('validation.save_success'));

    }

    /**
     * Remove the specified DocumentTypeRule from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_type_rules_remove',Auth::user()->user_type_code)){
            
            $documentTypeRule = $this->documentTypeRuleRepository->findWithoutFail($id);

            if (empty($documentTypeRule)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('documentTypeRules.index'));
            }

            $this->documentTypeRuleRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu DocumentTypeRule ID: '.$id.' Code: '.$documentTypeRule->liberation_rule_code.' - '.$documentTypeRule->document_type_code;
            $log = App\Models\Log::wlog('document_type_rules_remove', $descricao);

            //Atualiza a ordem das linhas que sobraram
            DB::table('document_type_rules')
            ->where('company_id', Auth::user()->company_id)
            ->where('document_type_code', $documentTypeRule->document_type_code)
            ->where('order','>',$documentTypeRule->order)
            ->decrement('order');



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
    public function getData($document_type_code)
    {
        return Datatables::of(App\Models\DocumentTypeRule::getDocumentTypeRules($document_type_code))->make(true);
    }
}
