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
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventoryItemsImport;
use App;
use Auth;
use Flash;
use Lang;

class InventoryController extends AppBaseController
{
    
    private $documentRepository;
    private $documentItemRepository;

    public function __construct(DocumentRepository $docRepo, DocumentItemRepository $itemRepo)
    {
        $this->documentRepository = $docRepo;
        $this->documentItemRepository = $itemRepo;
    }

    public function index(){
        return view('modules.inventory.gridDoc'); 
    }

    //--------------------------------------------------------------------------------------------
    //                                     Funções de Documentos
    //--------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------

    /**
     * Mostra o formulário para criação de documento de Inventário.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_inv_add',Auth::user()->user_type_code)){
            //Busca os tipos de documentos para o movimento de inventário
            $document_types = App\Models\DocumentType::getDocumentTypes('090');

            return view('modules.inventory.createDocument')->with('document_types',$document_types);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('inventory'));
        }
    }

    /**
     * Grava o novo documento de inventário
     *
     * @param CreateDocumentRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentRequest $request)
    {
        $input = $request->all();

        //Concatena todos os parametros informados em uma string separando por ; e grava no campo comments
        //O tratamento é feito no app coletor
        $parameters = "550_contagens=".$input['counts'].";550_valida_saldo=".
                      $input['vstock'].";550_valida_endereco=".$input['vlocation'].
                      ";550_valida_produto=".$input['vproduct'].";550_produto_default=".$input['productdef'].
                      ";550_endereco_default=".$input['locationdef'];

        $input['comments'] = $parameters;
        $deposits = (empty($input['deposits']))? '' : $input['deposits'];
        
        //Verifica se número do documento é valido (não existe outro doc com o mesmo tipo / numero)
        $countDoc = App\Models\Document::valDocumentNumber($input['document_type_code'], $input['number']);
        if($countDoc == 0){
            //Pode criar
            $document = $this->documentRepository->create($input);
            Flash::success(Lang::get('validation.save_success'));
        }else{
            Flash::error(Lang::get('validation.document_number'));
            return redirect(route('inventory.create'));
        }
       
        //Pega todos os saldos para montar a tela de itens
        $stocks = App\Models\Stock::getStockInv($deposits, $document->id);
        
        //Valida o tipo de inventário e já encaminha para a seleção de itens
        if($input['document_type_code'] == 'IVD'){
            //Chama a função que mostra tela de seleção de itens
            selectItems($document_id);
        }else{
            return redirect(route('inventory.index'));
        }
        
    }

    /**
     * Mostra o formulário para edição de documento de inventário
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_inv_edit',Auth::user()->user_type_code)){

            $document = $this->documentRepository->findWithoutFail($id);
            
            //Busca os tipos de documentos para o movimento de inventário
            $document_types = App\Models\DocumentType::getDocumentTypes('030');

            //Valida se o documento existe e se pertence a esse módulo (inventário)
            if (empty($document) || !array_key_exists($document->document_type_code, $document_types->toArray())) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('inventory.index'));
            }

            return view('modules.inventory.editDocument')->with('document', $document)
                                                          ->with('document_types', $document_types);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('inventory.index'));
        }
    }

     /**
     * Atualiza o documento de inventário
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

            //Concatena todos os parametros informados em uma string separando por ; e grava no campo comments
            //O tratamento é feito no app coletor
            $parameters = "550_contagens=".$requestF['counts'].";550_valida_saldo=".
            $requestF['vstock'].";550_valida_endereco=".$requestF['vlocation'].
            ";550_valida_produto=".$requestF['vproduct'].";";

            $requestF['comments'] = $parameters;

            $descricao = 'Alterou Documento ID: '.$id.' - '.$requestF['document_type_code'].' '.$requestF['number'];
            $log = App\Models\Log::wlog('documents_inv_edit', $descricao);


            $document = $this->documentRepository->update($request->all(), $id);

            Flash::success(Lang::get('validation.update_success'));
        }

        return redirect(route('inventory.index'));
    }

    /**
     * Libera contagem de inventário
     *
     * @param CreateDocumentRequest $request
     *
     * @return Response
     */
    public function liberate($document_id, $cont)
    {
        $document = $this->documentRepository->findWithoutFail($document_id);

        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_inv_lib',Auth::user()->user_type_code)){
            $return = App\Models\Document::liberateInventory($document_id, $cont);

            if($return['erro'] == 0){
                //Grava Logs
                $descricao = 'Liberou '.$cont.'a Contagem de Inventário';
                $log = App\Models\Log::wlog('documents_inv_lib', $descricao, $document_id);

                //Flash::success(Lang::get('infos.liberation_inv'));
                return array('success',Lang::get('infos.liberation_inv', ['doc' =>  $document->number,
                                                                        'cont' => $cont.'ª']));
            }else{
                //Erro ao retornar
                return array('danger',$return['msg']);
            }
        }else{
            //Sem permissão
            //Flash::error(Lang::get('validation.permission'));
            return array('danger',Lang::get('validation.permission'));
        }

    }

    /**
     * Retorna inventário
     *
     * @param CreateDocumentRequest $request
     *
     * @return Response
     */
    public function return($document_id)
    {

        $document = $this->documentRepository->findWithoutFail($document_id);

        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_inv_ret',Auth::user()->user_type_code)){
            $return = App\Models\Document::returnInventory($document_id);

            if($return['erro'] == 0){
                //Grava Logs
                $descricao = 'Retornou Documento de Inventário';
                $log = App\Models\Log::wlog('documents_inv_ret', $descricao, $document_id);
           
                return array('success',Lang::get('infos.return_doc', ['doc' =>  $document->number]));
            }else{
                //Erro ao retornar
                return array('danger',$return['msg']);
            }
        }else{
            //Sem permissão
            //Flash::error(Lang::get('validation.permission'));
            return array('danger',Lang::get('validation.permission'));
        }

    }

    /**
     * Mostra a tela de importação de planilha para inventário
     *
     * @return Response
     */

    public function showImportExcel()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_inv_imp',Auth::user()->user_type_code)){

            return view('modules.inventory.importExcel');
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('production'));
        }

    }

    /**
     * Valida planilha excel enviada e insere os itens no inventario
     *
     * @return Response
     */

    public function importExcel(Request $request)
    {
        $input = $request->all();

        //Concatena todos os parametros informados em uma string separando por ; e grava no campo comments
        //O tratamento é feito no app coletor
        $parameters = "550_contagens=".$input['counts'].";550_valida_saldo=".
                      $input['vstock'].";550_valida_endereco=".$input['vlocation'].
                      ";550_valida_produto=".$input['vproduct'];
        $pathFile = $input['fileExcel']->getRealPath();
        Excel::import($erro = new InventoryItemsImport($parameters), $pathFile);


        Flash::success('Inventário criado com sucesso!');
        return redirect(route('inventory.index'));
        
    }


    //--------------------------------------------------------------------------------------------
    //                                     Funções de Itens
    //--------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------

    /**
     * Mostra o grid de detalhes do documento de inventário
     *
     * @return Response
     */
    public function showItems($document_id)
    {
        $document = $this->documentRepository->findWithoutFail($document_id);
        return view('modules.inventory.gridItem')->with('document',$document);
    }


    /**
     * Mostra o formulário para inserção de itens em um Inventário
     *
     * @return Response
     */

    public function selectItems($document_id, Request $request)
    {
        if ($request->isMethod('POST')) {
            $input = $request->all(); 
            $deposits = (empty($input['deposits']))? '' : $input['deposits'];
        }else{
            //Se não informou depósitos por padrão, não lista nada
            $deposits = 'DEP01,DEP02,';
        }
        
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_inv_item_add',Auth::user()->user_type_code)){
            $document = $this->documentRepository->findWithoutFail($document_id);

            //Pega todos os saldos para montar a tela de itens
            $stocks = App\Models\Stock::getStockInv($deposits, $document->id);
           
            return view('modules.inventory.selectItems')->with('document',$document)
                                                        ->with('stocks', $stocks)
                                                        ->with('depositAnt', '');
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('inventory'));
        }

    }


    /**
     * Grava o novo item de um documento de inventário
     *
     * @param Document $document_id
     *
     * @return Response
     */
    public function storeItem($document_id, Request $request)
    {
        $input = $request->all(); 
        
        //Loop no array detalhado de cada deposito para pegar produtos e endereços
        foreach($input['items'] as $detailItem){
            //Quebra as informações pelo caractere '+', que separa o endereço do produto
            $detail = explode('+',$detailItem);
            //Pega saldos do produto + endereço
            $stocks = App\Models\Stock::getStock($detail[0], $detail[1], 2);
            //Loop nos saldos
            foreach($stocks as $stock){
                //Insere o item na tabela de itens de inventário
                $invItem = new App\Models\InventoryItem();
                $invItem->company_id = Auth::user()->company_id;
                $invItem->document_id = $document_id;
                $invItem->location_code = $stock['location_code'];
                $invItem->label_id = $stock['label_id'];
                $invItem->product_code = $stock['product_code'];
                $invItem->pallet_id = $stock['pallet_id'];
                $invItem->qty_wms = $stock['prim_qty'];
                $invItem->uom_code = $stock['prim_uom_code'];
                $invItem->inventory_status_id = 0;
                $invItem->save();

            }
        }

        return redirect(url('inventory/'.$document_id.'/selectItems'));

    }

    /**
     * Mostra o formulário para edição de itens em um documento de inventário
     *
     * @return Response
     */

    public function editItem($document_id, $document_item_id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_inv_item_edit',Auth::user()->user_type_code)){

            $document = $this->documentRepository->findWithoutFail($document_id);
            $document_item = $this->documentItemRepository->findWithoutFail($document_item_id);

            return view('modules.inventory.editItem')->with('document',$document)
                                                      ->with('documentItem',$document_item);
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('inventory/'.$input['document_id'].'/items'));
        }

    }

    /**
     * Atualiza o item de um documento de inventário
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
            $log = App\Models\Log::wlog('documents_inv_item_edit', $descricao);


            $documentItem = $this->documentItemRepository->update($request->all(), $id);

            Flash::success(Lang::get('validation.update_success'));
        }

        return redirect(url('inventory/'.$requestF['document_id'].'/items'));

    }

    public function getItems($document_id){
        $documents = App\Models\DocumentItem::where('document_id',$document_id)->get();
        return $documents->toArray();
    }
}
