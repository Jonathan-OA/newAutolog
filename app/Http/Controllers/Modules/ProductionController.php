<?php

namespace App\Http\Controllers\Modules;

use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Repositories\DocumentRepository;
use App\Http\Requests\CreateDocumentItemRequest;
use App\Http\Requests\UpdateDocumentItemRequest;
use App\Repositories\DocumentItemRepository;
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
    private $documentItemRepository;

    public function __construct(DocumentRepository $docRepo, DocumentItemRepository $itemRepo)
    {
        $this->documentRepository = $docRepo;
        $this->documentItemRepository = $itemRepo;
    }

    public function index(){
        return view('modules.production.gridDoc'); 
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
     * @param CreateDocumentRequest $request
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
     * @param UpdateDocumentRequest $request
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


    /**
     * Mostra o formulário para impressão de etiquetas de produção
     *
     * @return Response
     */

    public function showPrint($document_id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_prod_print',Auth::user()->user_type_code)){
            $document = $this->documentRepository->findWithoutFail($document_id);
            $documentItems = App\Models\DocumentItem::getInfosForPrint($document_id);

            return view('modules.production.printLabels')->with('document',$document)
                                                         ->with('documentItems', $documentItems);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('production'));
        }

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
        return view('modules.production.gridItem')->with('document',$document);
    }


    /**
     * Mostra o formulário para criação de itens em um documento de produção
     *
     * @return Response
     */

    public function createItem($document_id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_prod_item_add',Auth::user()->user_type_code)){
            $document = $this->documentRepository->findWithoutFail($document_id);
            return view('modules.production.createItem')->with('document',$document);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('production'));
        }

    }


    /**
     * Grava o novo item de um documento de produção
     *
     * @param CreateDocumentItemRequest $request
     *
     * @return Response
     */
    public function storeItem(CreateDocumentItemRequest $request)
    {
        $input = $request->all();       

        $documentItem = $this->documentItemRepository->create($input);
        Flash::success(Lang::get('validation.save_success'));

        return redirect(url('production/'.$input['document_id'].'/items'));

    }

    /**
     * Mostra o formulário para edição de itens em um documento de produção
     *
     * @return Response
     */

    public function editItem($document_id, $document_item_id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_prod_item_edit',Auth::user()->user_type_code)){

            $document = $this->documentRepository->findWithoutFail($document_id);
            $document_item = $this->documentItemRepository->findWithoutFail($document_item_id);

            return view('modules.production.editItem')->with('document',$document)
                                                      ->with('documentItem',$document_item);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('production/'.$input['document_id'].'/items'));
        }

    }

    /**
     * Atualiza o item de um documento de produção
     *
     * @param  int              $id
     * @param UpdateDocumentItemRequest $request
     *
     * @return Response
     */
    public function updateItem($id, UpdateDocumentItemRequest $request)
    {
        
        $documentItem = $this->documentItemRepository->findWithoutFail($id);
        
        //Valida se item foi encontrado
        if (empty($documentItem)) {
            Flash::error(Lang::get('validation.not_found'));
        }else{
            //Grava log
            $requestF = $request->all();
            $descricao = 'Alterou Item ID: '.$id.' - '.$requestF['product_code'].' - '.$requestF['qty'].' '.$requestF['uom_code'].' - Lote: '.$requestF['batch'].' //Doc_ID: '.$requestF['document_id'];
            $log = App\Models\Log::wlog('documents_prod_item_edit', $descricao);


            $documentItem = $this->documentItemRepository->update($request->all(), $id);

            Flash::success(Lang::get('validation.update_success'));
        }

        return redirect(url('production/'.$requestF['document_id'].'/items'));

    }

     



    public function getItems($document_id){
        $documents = App\Models\DocumentItem::where('document_id',$document_id)->get();
        return $documents->toArray();
    }
}
