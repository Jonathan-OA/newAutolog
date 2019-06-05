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

class ReceiptController extends AppBaseController
{
    
    private $documentRepository;
    private $documentItemRepository;

    public function __construct(DocumentRepository $docRepo, DocumentItemRepository $itemRepo)
    {
        $this->documentRepository = $docRepo;
        $this->documentItemRepository = $itemRepo;
    }

    public function index(){
        return view('modules.receipt.gridDoc'); 
    }

    //--------------------------------------------------------------------------------------------
    //                                     Funções de Documentos
    //--------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------

    /**
     * Mostra o formulário para criação de documento de recebimento.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_rec_add',Auth::user()->user_type_code)){
            //Busca os tipos de documentos para o movimento de recebimento
            $document_types = App\Models\DocumentType::getDocumentTypes('010');

            return view('modules.receipt.createDocument')->with('document_types',$document_types);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('receipt'));
        }
    }

    /**
     * Grava o novo documento de recebimento
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
            return redirect(route('receipt.create'));
        }
        return redirect(route('receipt.index'));
    }

    /**
     * Mostra o formulário para edição de documento de recebimento
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_rec_edit',Auth::user()->user_type_code)){

            $document = $this->documentRepository->findWithoutFail($id);
            
            //Busca os tipos de documentos para o movimento de recebimento
            $document_types = App\Models\DocumentType::getDocumentTypes('010');

            //Valida se o documento existe e se pertence a esse módulo (recebimento)
            if (empty($document) || !array_key_exists($document->document_type_code, $document_types->toArray())) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('receipt.index'));
            }

            return view('modules.receipt.editDocument')->with('document', $document)
                                                          ->with('document_types', $document_types);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('receipt.index'));
        }
    }

     /**
     * Atualiza o documento de recebimento
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
            $log = App\Models\Log::wlog('documents_rec_edit', $descricao);


            $document = $this->documentRepository->update($request->all(), $id);

            Flash::success(Lang::get('validation.update_success'));
        }

        return redirect(route('receipt.index'));
    }


    /**
     * Mostra o formulário para impressão de etiquetas de recebimento
     *
     * @return Response
     */

    public function showPrint($document_id, $filePrint = '', $print = false)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_rec_print',Auth::user()->user_type_code)){
            $document = $this->documentRepository->findWithoutFail($document_id);
            $documentItems = App\Models\DocumentItem::getInfosForPrint($document_id);

            //Busca parâmetro print_server com o IP do servidor de impressão da rede
            $print_server = App\Models\Parameter::getParam('print_server', 'localhost');

            return view('modules.receipt.printLabels')->with('document',$document)
                                                         ->with('documentItems', $documentItems)
                                                         ->with('print_server', $print_server);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('receipt'));
        }

    }


    /**
     * Cria labels e retorna arquivo de impressão
     *
     * @param CreateLabelRequest $request
     *
     * @return Response
     */
    public function print(Request $request)
    {
        $input = $request->all(); 

        $printer_type = $input['printer_type_code'];    //Tipo
        $printer = $input['printer'];                   //Fila
        $label_type_code = $input['label_type_code'];   //Tipo de etiqueta

        $document = $this->documentRepository->findWithoutFail($input['document_id']);     //Documento

        //Busca comandos de impressão para a ETIQUETA / TIPO DE IMPRESSORA
        $comm = App\Models\LabelLayout::getCommands($label_type_code, $printer_type);

        //'Arquivo' com todos os comandos substituidos
        $fileComm = '';

        //Loop nas linhas informadas na impressão
        foreach($input['infos'] as $line ){

            $line['document_id'] = $input['document_id'];
            
            //Pega informações da UOM (GERA_ID, CONFIRMA_LOTE, ETC..)
            $level = App\Models\Packing::getLevel($line['product_code'], $line['uom_code']);

            if(count($level) > 0 && !empty($level[0]['print_label'])){

                 //Valida cadastro Print_Label (GERA_ID)
                if($level[0]['print_label'] == 1){
                    
                    //Loop para gerar a quantidade de etiquetas informadas no campo aImprimir
                    for($i = 0;$i < $line['qty_print']; $i++){
                        $label = $label = App\Models\Label::createLabel($line);
                        //Pega as informações necessárias para impressão
                        $infos = App\Models\Label::getInfosForPrint($label->id);
                        //Substitui as Variáveis no layout
                        $label_commands = App\Models\LabelLayout::subCommands($comm, $infos);
                        //Adiciona no 'arquivo'
                        $fileComm .= $label_commands;
                    }
                }else{
                    //Cria uma etiqueta e imprime o número de cópias
                    $label = $label = App\Models\Label::createLabel($line);
                    //Pega as informações necessárias para impressão
                    $infos = App\Models\Label::getInfosForPrint($label->id);
                    //Substitui as Variáveis no layout
                    $label_commands = App\Models\LabelLayout::subCommands($comm, $infos);
                    //Adiciona no 'arquivo'
                    $fileComm .= $label_commands;
                }
            }else{
                //Unidade / Produto não cadastrados na tabela de embalagens
            }
           
        }

        //Retorna para o arquivo com as variáveis já substituídas
        return $fileComm;


    }

    //--------------------------------------------------------------------------------------------
    //                                     Funções de Itens
    //--------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------

    /**
     * Mostra o grid de detalhes do documento de recebimento
     *
     * @return Response
     */
    public function showItems($document_id)
    {
        $document = $this->documentRepository->findWithoutFail($document_id);
        return view('modules.receipt.gridItem')->with('document',$document);
    }


    /**
     * Mostra o formulário para criação de itens em um documento de recebimento
     *
     * @return Response
     */

    public function createItem($document_id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_rec_item_add',Auth::user()->user_type_code)){
            $document = $this->documentRepository->findWithoutFail($document_id);
            return view('modules.receipt.createItem')->with('document',$document);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('receipt'));
        }

    }


    /**
     * Grava o novo item de um documento de recebimento
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

        return redirect(url('receipt/'.$input['document_id'].'/items'));

    }

    /**
     * Mostra o formulário para edição de itens em um documento de recebimento
     *
     * @return Response
     */

    public function editItem($document_id, $document_item_id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_rec_item_edit',Auth::user()->user_type_code)){

            $document = $this->documentRepository->findWithoutFail($document_id);
            $document_item = $this->documentItemRepository->findWithoutFail($document_item_id);

            return view('modules.receipt.editItem')->with('document',$document)
                                                      ->with('documentItem',$document_item);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('receipt/'.$input['document_id'].'/items'));
        }

    }

    /**
     * Atualiza o item de um documento de recebimento
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
            $log = App\Models\Log::wlog('documents_rec_item_edit', $descricao);


            $documentItem = $this->documentItemRepository->update($request->all(), $id);

            Flash::success(Lang::get('validation.update_success'));
        }

        return redirect(url('receipt/'.$requestF['document_id'].'/items'));

    }

     



    public function getItems($document_id){
        $documents = App\Models\DocumentItem::where('document_id',$document_id)->get();
        return $documents->toArray();
    }
}
