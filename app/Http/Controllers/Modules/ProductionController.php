<?php

namespace App\Http\Controllers\Modules;

use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Repositories\DocumentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Prettus\Repository\Criteria\RequestCriteria;
use App;
use Auth;
use Flash;
use Lang;

class ProductionController extends AppBaseController
{
    
    private $documentRepository;

    public function __construct(DocumentRepository $docRepo)
    {
        $this->documentRepository = $docRepo;
    }

    public function index(){
        return view('modules.production.grid'); 
    }

    //--------------------------------------------------------------------------------------------
    //                                     Funções de Documentos
    //--------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------

    /**
     * Mostra o formulário para criação de documento de produção.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_prod_add',Auth::user()->user_type_code)){
            //Busca os tipos de documentos para o movimento de produção
            $document_types = App\Models\DocumentType::getDocumentTypes('030');

            return view('modules.production.createDocument')->with('document_types',$document_types);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('production'));
        }
    }

    /**
     * Grava o novo documento de produção
     *
     * @param CreateConfigRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentRequest $request)
    {
        $input = $request->all();       

        //Verifica se número do documento é valido (não existe outro doc com o mesmo tipo / numero)
        $countDoc = App\Models\Document::valDocumentNumber($input['document_type_code'], $input['number']);
        if($countDoc == 0){
            //Pode criar
            $document = $this->documentRepository->create($input);
            Flash::success(Lang::get('validation.save_success'));
        }else{
            Flash::error(Lang::get('validation.document_number'));
            return redirect(route('production.create'));
        }
        return redirect(route('production.index'));
    }

    /**
     * Mostra o formulário para edição de documento de produção
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_prod_edit',Auth::user()->user_type_code)){

            $document = $this->documentRepository->findWithoutFail($id);
            
            //Busca os tipos de documentos para o movimento de produção
            $document_types = App\Models\DocumentType::getDocumentTypes('030');

            //Valida se o documento existe e se pertence a esse módulo (produção)
            if (empty($document) || !array_key_exists($document->document_type_code, $document_types->toArray())) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('production.index'));
            }

            return view('modules.production.editDocument')->with('document', $document)
                                                          ->with('document_types', $document_types);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('production.index'));
        }
    }

     /**
     * Atualiza o documento de produção
     *
     * @param  int              $id
     * @param UpdateBlockedGroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentRequest $request)
    {
        $document = $this->documentRepository->findWithoutFail($id);

        
        //Valida se documento foi encontrado
        if (empty($document)) {
            Flash::error(Lang::get('validation.not_found'));
        }else{
            //Grava log
            $requestF = $request->all();
            $descricao = 'Alterou Documento ID: '.$id.' - '.$requestF['document_type_code'].' '.$requestF['number'];
            $log = App\Models\Log::wlog('documents_prod_edit', $descricao);


            $document = $this->documentRepository->update($request->all(), $id);

            Flash::success(Lang::get('validation.update_success'));
        }

        return redirect(route('production.index'));
    }



    //--------------------------------------------------------------------------------------------
    //                                     Funções de Itens
    //--------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------

    /**
     * Mostra o grid de detalhes do documento de produção
     *
     * @return Response
     */
    public function showItems($document_id)
    {
        $document = $this->documentRepository->findWithoutFail($document_id);

        return view('modules.production.gridDet')->with('document',$document);

    }


    /**
     * Mostra o formulário para criação de itens em um documento de produção
     *
     * @return Response
     */
    public function createItem($document_id)
    {
        $document = $this->documentRepository->findWithoutFail($document_id);

        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_prod_item_add',Auth::user()->user_type_code)){

            return view('modules.production.createItem')->with('document',$document);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('production'));
        }

    }

    /**
     * Mostra o formulário para edição de itens em um documento de produção
     *
     * @return Response
     */
    public function editItem($document_id)
    {

    }
    


    public function items($id){
        return view('modules.production.gridDet')->with(['document' => $id]); 
    }

    public function getItems($document_id){
        $documents = App\Models\DocumentItem::where('document_id',$document_id)->get();
        return $documents->toArray();
    }
}
