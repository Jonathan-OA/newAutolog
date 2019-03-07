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
        $moviment = App\Models\DocumentType::getMoviment($document_type_code);
        $rc = App\Models\Moviment::getClass($moviment[0]);
        $class = $rc['class'];
        $rulesDocument = get_class_methods($class);
     print_r($rulesDocument);exit;

        $this->documentTypeRuleRepository->pushCriteria(new RequestCriteria($request));
        $documentTypeRules = $this->documentTypeRuleRepository->all();

        return view('document_type_rules.index')
            ->with('documentTypeRules', $documentTypeRules);
    }

    /**
     * Show the form for creating a new DocumentTypeRule.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_type_rules_add',Auth::user()->user_type_code)){

            return view('document_type_rules.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('document_type_rules.index'));
        }
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

        $documentTypeRule = $this->documentTypeRuleRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('documentTypeRules.index'));
    }

    /**
     * Display the specified DocumentTypeRule.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documentTypeRule = $this->documentTypeRuleRepository->findWithoutFail($id);

        if (empty($documentTypeRule)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('documentTypeRules.index'));
        }

        return view('document_type_rules.show')->with('documentTypeRule', $documentTypeRule);
    }

    /**
     * Show the form for editing the specified DocumentTypeRule.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_type_rules_edit',Auth::user()->user_type_code)){

            $documentTypeRule = $this->documentTypeRuleRepository->findWithoutFail($id);

            if (empty($documentTypeRule)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('documentTypeRules.index'));
            }

            return view('document_type_rules.edit')->with('documentTypeRule', $documentTypeRule);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('document_type_rules.index'));
        }
    }

    /**
     * Update the specified DocumentTypeRule in storage.
     *
     * @param  int              $id
     * @param UpdateDocumentTypeRuleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentTypeRuleRequest $request)
    {
        $documentTypeRule = $this->documentTypeRuleRepository->findWithoutFail($id);

        if (empty($documentTypeRule)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('documentTypeRules.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou DocumentTypeRule ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('document_type_rules_edit', $descricao);


        $documentTypeRule = $this->documentTypeRuleRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('documentTypeRules.index'));
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
            $descricao = 'Excluiu DocumentTypeRule ID: '.$id;
            $log = App\Models\Log::wlog('document_type_rules_remove', $descricao);


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
        return Datatables::of(App\Models\DocumentTypeRule::where('company_id', Auth::user()->company_id))->make(true);
    }
}
