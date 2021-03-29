<?php

namespace App\Http\Controllers\Modules;

use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Repositories\DocumentRepository;
use App\Http\Requests\CreateDocumentItemRequest;
use App\Http\Requests\UpdateDocumentItemRequest;
use App\Http\Requests\AuditLocationRequest;
use App\Repositories\DocumentItemRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Prettus\Repository\Criteria\RequestCriteria;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventoryItemsImport;
use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\Customer;
use App\Models\InventoryItem;
use App\Models\Activity;
use App\Models\Task;

ini_set('max_execution_time', 1200); //10 minutes
ini_set('memory_limit', '2048M'); //Limite de

class InventoryController extends AppBaseController
{

    private $documentRepository;
    private $documentItemRepository;

    public function __construct(DocumentRepository $docRepo, DocumentItemRepository $itemRepo)
    {
        $this->documentRepository = $docRepo;
        $this->documentItemRepository = $itemRepo;
    }

    public function index()
    {
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
        if (App\Models\User::getPermission('documents_inv_add', Auth::user()->user_type_code)) {
            //Busca os tipos de documentos para o movimento de inventário
            $document_types = App\Models\DocumentType::getDocumentTypes('090');

            return view('modules.inventory.createDocument')->with('document_types', $document_types);
        } else {
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
        $parameters = "550_contagens=" . $input['counts'] . ";550_valida_saldo=" .
            $input['vstock'] . ";550_valida_endereco=" . $input['vlocation'] .
            ";550_valida_produto=" . $input['vproduct'] . ";550_produto_default=" . $input['productdef'] .
            ";550_endereco_default=" . $input['locationdef'];

        $input['comments'] = $parameters;
        $deposits = (empty($input['deposits'])) ? '' : $input['deposits'];

        //Verifica se número do documento é valido (não existe outro doc com o mesmo tipo / numero)
        $countDoc = App\Models\Document::valDocumentNumber($input['document_type_code'], $input['number']);
        if ($countDoc == 0) {
            //Pode criar
            $document = $this->documentRepository->create($input);
            Flash::success(Lang::get('validation.save_success'));
        } else {
            Flash::error(Lang::get('validation.document_number'));
            return redirect(route('inventory.create'));
        }

        //Pega todos os saldos para montar a tela de itens
        $stocks = App\Models\Stock::getStockInv($deposits, $document->id);

        //Valida o tipo de inventário e já encaminha para a seleção de itens
        if ($input['document_type_code'] == 'IVD') {
            //Chama a função que mostra tela de seleção de itens
            selectItems($document_id);
        } else {
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
        if (App\Models\User::getPermission('documents_inv_edit', Auth::user()->user_type_code)) {

            $document = $this->documentRepository->findWithoutFail($id);

            //Busca os tipos de documentos para o movimento de inventário
            $document_types = App\Models\DocumentType::getDocumentTypes('090');

            //Valida se o documento existe e se pertence a esse módulo (inventário)
            if (empty($document) || !array_key_exists($document->document_type_code, $document_types->toArray())) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('inventory.index'));
            }

            return view('modules.inventory.editDocument')->with('document', $document)
                ->with('document_types', $document_types);
        } else {
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
        } else {
            //Grava log
            $requestF = $request->all();

            //Concatena todos os parametros informados em uma string separando por ; e grava no campo comments
            //O tratamento é feito no app coletor
            if (empty($requestF['comments'])) {
                $parameters = "550_contagens=" . $requestF['counts'] . ";550_valida_saldo=" .
                    $requestF['vstock'] . ";550_valida_endereco=" . $requestF['vlocation'] .
                    ";550_valida_produto=" . $requestF['vproduct'] . ";";

                $requestF['comments'] = $parameters;
            }


            $descricao = 'Alterou Documento ID: ' . $id . ' - ' . $requestF['document_type_code'] . ' ' . $requestF['number'] . ' - Valor: ' . $requestF['inventory_value'];
            $log = App\Models\Log::wlog('documents_inv_edit', $descricao, $id);


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
        if (App\Models\User::getPermission('documents_inv_lib', Auth::user()->user_type_code)) {
            $return = App\Models\Document::liberateInventory($document_id, $cont);

            if ($return['erro'] == 0) {
                //Grava Logs
                $descricao = 'Liberou ' . $cont . 'a Contagem de Inventário';
                $log = App\Models\Log::wlog('documents_inv_lib', $descricao, $document_id);

                //Flash::success(Lang::get('infos.liberation_inv'));
                return array('success', Lang::get('infos.liberation_inv', [
                    'doc' =>  $document->number,
                    'cont' => $cont . 'ª'
                ]));
            } else {
                //Erro ao retornar
                return array('danger', $return['msg']);
            }
        } else {
            //Sem permissão
            //Flash::error(Lang::get('validation.permission'));
            return array('danger', Lang::get('validation.permission'));
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
        if (App\Models\User::getPermission('documents_inv_ret', Auth::user()->user_type_code)) {
            $return = App\Models\Document::returnInventory($document_id);

            if ($return['erro'] == 0) {
                //Grava Logs
                $descricao = 'Retornou Documento de Inventário';
                $log = App\Models\Log::wlog('documents_inv_ret', $descricao, $document_id);

                return array('success', Lang::get('infos.return_doc', ['doc' =>  $document->number]));
            } else {
                //Erro ao retornar
                return array('danger', $return['msg']);
            }
        } else {
            //Sem permissão
            //Flash::error(Lang::get('validation.permission'));
            return array('danger', Lang::get('validation.permission'));
        }
    }

    /**
     * Mostra a tela de importação de planilha para inventário
     *
     * @return Response
     */

    public function showImportFile()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if (App\Models\User::getPermission('documents_inv_imp', Auth::user()->user_type_code)) {
            return view('modules.inventory.importFile');
        } else {
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('inventory'));
        }
    }

    /**
     * Confirma a ordem dos campos do arquivo enviado para importação
     * 
     *
     * @return Response
     */

    public function confirmImportFile(Request $request)
    {
        $input = $request->all();

        //Pega a extensão e nome do arquivo
        $extFile = $input['fileExcel']->clientExtension();
        $fileName = $input['fileExcel']->getClientOriginalName();

        //Campos presentes no arquivo (informado pelo usuário na tela anterior)
        $fields = $input['fields'];
        $customer_code = $input['customer_code'];
        $inventory_value = $input['cost']; //Preço por Leitura
        $billing_type = $input['billing_type']; //Tipo de Cobrança

        //Valida se Cliente existe
        $authCustomer = Customer::where([
            ['code', $customer_code],
            ['company_id', Auth::user()->company_id]
        ])->get()->count();

        if ($authCustomer == 0) {
            Flash::error(Lang::get('validation.customer_not_exist'));
            return redirect(url('inventory/importFile'))->with('customer_code', $customer_code)
                ->with('inventory_value', $inventory_value);
        }

        if (in_array($extFile, ['xls', 'xlsx'])) {
            //Salva o arquivo na pasta temporária e depois envia o path correto
            //Excel::import($erro = new InventoryItemsImport($parameters), $input['fileExcel']);
  
        } else  if (in_array($extFile, ['txt', 'csv'])) {
            $file = fopen($input['fileExcel'], "r");
            //Pega apenas a primeira linha do arquivo
            $primLinha = fgets($file);

            //Busca o separador que pode ser ponto e virgula ou apenas virgula
            $sepFile = (strpos($primLinha, ";")) ? ";" : (strpos($primLinha, ",") ? "," : "");
            if ($sepFile <> "") {
                $infos = explode($sepFile, $primLinha);
                $indx = count($infos) - 1;
                if (trim($infos[$indx]) == "") {
                    //Exclui ultima posição do array caso esteja vazio (; final)
                    array_pop($infos);
                }
                $countColumns = count($infos);
            }

            //Valida se as informações setadas na tela anterior batem com a quantidade de infos (colunas) no txt
            if ($countColumns <> count($fields)) {
                Flash::error(Lang::get('validation.infos_import_error', ['fields' => count($fields), 'columnsFile' => $countColumns]));
                return redirect(url('inventory/importFile'))->with('customer_code', $customer_code)
                    ->with('inventory_value', $inventory_value);
            }

            //Salva o arquivo no storage para ser obtido após a confirmação
            //Storage::putFileAs(storage_path(),$input['fileExcel'],$fileName);
            $input['fileExcel']->move(storage_path(), $fileName);

            return view('modules.inventory.confirmImportFile')->with('fileName', $fileName)
                ->with('extFile', $extFile)
                ->with('sepFile', $sepFile)
                ->with('infos', $infos)
                ->with('customer_code', $customer_code)
                ->with('inventory_value', $inventory_value)
                ->with('billing_type', $billing_type)
                ->with('fields', $fields);
        } else {
            //Arquivo invalido
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('inventory.importFile'));
        }
    }

    /**
     * Valida arquivo enviado com os parametroes e insere os itens no inventario
     *
     * @return Response
     */

    public function importFile(Request $request)
    {
        $input = $request->all();
        $fileName = $input['fileName']; //Nome do Arquivo salvo
        $extFile = $input['extFile']; //Extensão do arquivo salvo
        $sepFile = $input['sepFile']; //Separador de cada linha
        $customer_code = $input['customer_code']; //Cliente
        $inventory_value = $input['inventory_value']; //Valor por Leitura
        $billing_type = $input['billing_type']; //Tipo de Cobrança

        //Pega a ordem das colunas e suas informações
        //Inverte as chaves para que o índice seja a informação do campo e o valor da ordem
        //Ex: 'qde' => 0, 'end' => 1
        $fieldsOrder = array_flip($input['fieldsOrder']);
        $fieldsOrderJson = json_encode($fieldsOrder);

        //Concatena todos os parametros informados em uma string separando por ; e grava no campo comments
        //O tratamento é feito no app coletor
        $parameters = "550_contagens=" . $input['counts'] . ";550_valida_saldo=" .
            $input['vstock'] . ";550_valida_endereco=" . $input['vlocation'] ?? '' .
            ";550_valida_produto=" . $input['vproduct'] ?? '';

        //Confirma extensões validas para direcionar a importação correta
        if (in_array($extFile, ['xls', 'xlsx'])) {
            $file = fopen(storage_path() . '/' . $fileName, 'r');
        } elseif (in_array($extFile, ['txt', 'csv'])) {
            $file = fopen(storage_path() . '/' . $fileName, 'r');
            //Cria o objeto e chama a função passando os parâmetros do txt
            $importFile = new InventoryItemsImport($parameters, $customer_code, $inventory_value, $billing_type, $fieldsOrderJson);
            $ret = $importFile->array($file, array('order' => $fieldsOrder, 'separator' => $sepFile));

            if ($ret[1] <> 0) {

                //Remove da pasta local
                Storage::delete(storage_path() . '/' . $fileName);
                //Campos não preenchidos
                if ($ret[1] == 6) {
                    Flash::error($ret[2]);
                }else{
                    Flash::error('Erro ao importar o inventário.  Código de Erro: ' . $ret[1]);
                }
                
                return redirect(route('inventory.importFile'));
            }else{
                $inventoryNumber = $ret[0];
                //Tudo certo, grava o arquivo no S3 para consultas futuras
                //Pasta no padrão CODE+BRANCH/CLIENTE/INVENTARIO
                $fileDest = Auth::user()->getCompanyInfo()->code.Auth::user()->getCompanyInfo()->branch.'/'.$customer_code.'/'.$inventoryNumber.'.txt';
                Storage::disk('s3')->put($fileDest, $file);

                //Remove da pasta local
                Storage::delete(storage_path() . '/' . $fileName);
                

            }
        } else {
            //Arquivo invalido
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('inventory.importFile'));
        }


        Flash::success('Inventário '.$inventoryNumber.' criado com sucesso!');
        return redirect(route('inventory.index'));
    }

    /**
     * Mostra a tela de exportação de planilha/txt para inventário
     * @return Response
     */

    public function showExportFile($document_id)
    {
        $document = $this->documentRepository->findWithoutFail($document_id);
        $idExport = App\Models\Customer::where('company_id',  Auth::user()->company_id)
            ->where('code', $document->customer_code)
            ->select('profile_export')
            ->get();
        $profileExport = $idExport[0]->profile_export;

        //Busca perfis de exportação já gravados
        $profiles = Profile::getProfiles('EXPORT');

        //Valida se usuário possui permissão para acessar esta opção
        if (App\Models\User::getPermission('documents_inv_exp', Auth::user()->user_type_code)) {
            return view('modules.inventory.exportFile')->with('document', $document)
                ->with('profiles', $profiles)
                ->with('profileExport', $profileExport);
        } else {
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('inventory'));
        }
    }

    /**
     * Realiza as validações e exporta as contagens para txt
     * @return Response
     */

    public function exportFile($document_id, Request $request)
    {
        $input = $request->all();
        $delimiter = $input['delimiter'];
        $final_delimiter = (isset($input['final_delimiter'])) ? 1 : 0;
        $fieldsOrder = $input['fieldsOrder'];
        $document = $this->documentRepository->findWithoutFail($document_id);

        //Gravar perfil de exportação para a proxima utilização
        //insert into profiles
        $jsonFields = array('fields' => array(), 'options' => array());
        //Variavel de controle para ver se detalha ou não por endereço
        $fieldLocation = 0;
        foreach ($fieldsOrder as $order => $field) {
            switch ($field) {
                case 'fix':
                    $jsonFields['fields'][] = array('code' => $field, $field . 'Format' => $input['fixFormat']);
                    break;
                case 'loc':
                    $fieldLocation = 1;
                        $jsonFields['fields'][] = array('code' => $field, $field . 'Max' => (isset($input[$field . 'Max'])) ? $input[$field . 'Max'] : "");
                        break;
                case 'dat':
                    $jsonFields['fields'][] = array('code' => $field, $field . 'Format' => (isset($input[$field . 'Format']) ? $input[$field . 'Format'] : ""));
                    break;
                case 'datexp':
                    $jsonFields['fields'][] = array('code' => $field, $field . 'Format' => (isset($input[$field . 'Format']) ? $input[$field . 'Format'] : ""));
                    break;
                case 'qde':
                    $jsonFields['fields'][] = array(
                        'code' => $field, $field . 'Dec' => (isset($input[$field . 'Dec']) ? $input[$field . 'Dec'] : ""),
                        $field . 'Max' => (isset($input[$field . 'Max']) ? $input[$field . 'Max'] : "")
                    );
                    break;
                default:
                    $jsonFields['fields'][] = array(
                        'code' => $field, $field . 'Max' => (isset($input[$field . 'Max']) ? $input[$field . 'Max'] : ""),
                        $field . 'Pre' => (isset($input[$field . 'Pre']) ? $input[$field . 'Pre'] : "")
                    );
                    break;
            }
        }
        $jsonFields['options'] = array('summarize' => $input['summarize']);

        //Cadastra o novo perfil de importação se não existir um igual
        $verProfile = Profile::where('company_id', Auth::user()->company_id)
            ->where('type', 'EXPORT')
            ->whereJsonContains('format', $jsonFields)
            ->get()
            ->count();

        if ($verProfile == 0) {
            $insertProfile = Profile::insertGetId(
                [
                    'company_id' => Auth::user()->company_id, 'type' => 'EXPORT', 'description' =>  $input['profile_desc'], 'delimiter' =>  $delimiter,
                    'format' => json_encode($jsonFields), 'created_at' => new \DateTime()
                ]
            );
            $input['profile_export'] = $insertProfile;
        }

        //Atualiza no cliente o ultimo perfil utilizado
        $updCustomer = Customer::where('company_id', Auth::user()->company_id)
            ->where('code', $document->customer_code)
            ->update(['profile_export' => $input['profile_export']]);

        $content = "";
        $fileName = "export_ivd_" . $document_id . "_" . date('Ymd') . "_" . date('His') . ".txt";
        //Pega as informações das contagens (se parametro summarize = 1, agrupa por item)
        if ($jsonFields['options']['summarize'] == 0) {
            $select = DB::table('activities')
                ->select(
                    DB::raw("products.code as prd"),
                    "products.description as dsc",
                    "activities.barcode as ean",
                    "activities.prim_qty as qde",
                    "activities.location_code as loc",
                    DB::raw(isset($input['datFormat']) ? "DATE_FORMAT(activities.start_date, '{$input['datFormat']}') as dat" : "'' as dat"),
                    DB::raw(isset($input['datexpFormat']) ? "DATE_FORMAT(CONVERT_TZ(NOW(),'SYSTEM','America/Sao_Paulo'), '{$input['datexpFormat']}') as datexp" : "'' as datexp"),
                    "labels.batch as lot",
                    DB::raw(isset($input['fixFormat']) ? "'{$input['fixFormat']}' as fix" : "'' as fix")
                )
                ->join('products', function ($join) {
                    $join->on('products.code', '=', 'activities.product_code')
                        ->whereColumn('products.company_id', 'activities.company_id');
                })
                ->join('packings', function ($join) {
                    $join->on('activities.product_code', '=', 'packings.product_code')
                        ->whereColumn('activities.uom_code', 'packings.uom_code')
                        ->whereColumn('activities.company_id', 'packings.company_id');
                })
                ->leftJoin('labels', 'labels.id', 'activities.label_id')
                ->where('activities.document_id', $document_id)
                ->where('activities.description', 'not like', 'Cancelamento%')
                ->where('activities.prim_qty', '>', 0)
                ->where('activities.activity_status_id', '<>', 9)
                ->get()
                ->toArray();
        } else {

            $locQuery = ($fieldLocation == 1) ? "inventory_items.location_code" : "";
            $groupLoc = ($fieldLocation == 1) ? ",inventory_items.location_code": "";
            $select = DB::table('inventory_items')
                ->select(
                    "products.code as prd",
                    "products.description as dsc",
                    "packings.barcode as ean",
                    DB::raw("SUM(inventory_items.qty_1count) as qde"),
                    DB::raw("' ' as loc"),
                    DB::raw("' ' as dat"),
                    DB::raw(isset($input['datexpFormat']) ? "DATE_FORMAT(NOW(), '{$input['datexpFormat']}') as datexp" : "'' as datexp"),
                    "labels.batch as lot",
                    DB::raw(isset($input['fixFormat']) ? "'{$input['fixFormat']}' as fix" : "'' as fix")
                )
                ->join('products', function ($join) {
                    $join->on('products.code', '=', 'inventory_items.product_code')
                        ->whereColumn('products.company_id', 'inventory_items.company_id');
                })
                ->join('packings', function ($join) {
                    $join->on('inventory_items.product_code', '=', 'packings.product_code')
                        ->whereColumn('inventory_items.uom_code', 'packings.uom_code')
                        ->whereColumn('inventory_items.company_id', 'packings.company_id');
                })
                ->leftJoin('labels', 'labels.id', 'inventory_items.label_id')
                ->where('inventory_items.document_id', $document_id)
                ->where('inventory_items.qty_1count', '>', 0)
                ->groupBy('products.code', 'products.description', 'packings.barcode', 
                          'labels.batch')
                ->get()
                ->toArray();
        }
        
        //Gera a variável com o conteudo do arquivo
        foreach ($select as $key => $line) {
            $row = "";
            //Loop no formato definido de exportação para ajustar as linhas
            foreach ($jsonFields['fields'] as $field) {
                $code = $field['code'];
                $valueField = $line->$code;

                switch ($code) {

                    case 'qde':
                        if ($valueField == '') $valueField = "0";
                        $max = ((isset($field[$code . 'Max']) && trim($field[$code . 'Max']) <> '') ? $field[$code . 'Max'] : 5);
                        $dec = (isset($field[$code . 'Dec']) ? $field[$code . 'Dec'] : 0);
                        $quebra = explode(".", $valueField);
                        //Valor decimal (Se for vazio, remove o ponto da quantidade)
                        $decValue = ($dec > 0) ? '.' . substr(str_pad((!isset($quebra[1]) ? '0' : $quebra[1]), ($dec), 0, \STR_PAD_RIGHT), 0, $dec) : '';
                        //se parametro summarize = 1, As linhas são quebradas com quantidade = 1
                        if ($jsonFields['options']['summarize'] == 0) {
                            //Se for 0 considera o tamanho real
                            if($max != 0){
                                $valueField = substr(str_pad(($valueField <> 0) ? 1 : 0, ($max - $dec), 0, \STR_PAD_LEFT), 0, ($max - $dec)) . $decValue;
                            }else{
                                //Não sumariza, mostra qde 1 por linha
                                $valueField = 1;
                            }
                        } else {
                            //Se for 0 considera o tamanho real
                            if($max != 0){
                                $valueField = substr(str_pad($quebra[0], ($max - $dec), 0, \STR_PAD_LEFT), 0, ($max - $dec)) . $decValue;
                            }else{
                                $valueField = (float)$valueField;
                            }
                        }
                        break;

                    case 'dsc':
                        $max = (isset($field[$code . 'Max']) ? $field[$code . 'Max'] : '');
                        $pre = (isset($field[$code . 'Pre']) ? (($field[$code . 'Pre'] == "") ? " " : $field[$code . 'Pre']) : '');
                        if ($max <> '')
                            $valueField = substr(str_pad($valueField, $max, "$pre", \STR_PAD_RIGHT), 0, $max);
                        break;

                    case 'prd':
                        $max = (isset($field[$code . 'Max']) ? $field[$code . 'Max'] : '');
                        $pre = (isset($field[$code . 'Pre']) ? (($field[$code . 'Pre'] == "") ? " " : $field[$code . 'Pre']) : '');
                        if ($max <> '')
                            $valueField = substr(str_pad($valueField, $max, "$pre", \STR_PAD_RIGHT), 0, $max);
                        break;
                }
                //Adiciona campo na linha
                $row .= $valueField . $delimiter;
            }


            //Se foi marcado para não ter o delimitador no final, remove 
            if($final_delimiter == 0){
                $row = substr($row, 0, -(strlen($delimiter)));
            }

            //se parametro summarize = 0, As linhas são quebradas com quantidade = 1
            if ($jsonFields['options']['summarize'] == 0) {
                //Contador inicia com o total a ser repetido e vai diminuindo até chegar 2, a ultima linha será adicionada abaixo
                for ($i = $line->qde; $i > 1; $i--) {
                    $content .= $row . "\n";
                }
            }
            
            //Adiciona linha no conteúdo do arquivo e pula para proxima linha
            $content .= $row . "\n";
            
        }

        //Grava o Arquivo
        Storage::disk('public')->put($fileName, $content);

        //Muda Status do documento para "Exportado"
        $document->document_status_id = 16;
        $document->save();

        //Chama a tela do grid principal passando o nome do arquivo para download
        return redirect('inventory')->with('fileDownload', $fileName);
    }

    /**
     * Mostra o formulário para inserção de itens 2ª e 3ª contagem
     *
     * @return Response
     */

    public function selectItemsNextCount($document_id, $invCount,  Request $request)
    {
        $deposits = $divMax = $divMin = '';

        //Se vier pelo Post, significa que é filtro
        if ($request->isMethod('POST')) {
            $deposits = array_filter(explode(',', $request['filterDep']));
            $divMax = $request['filterDiv1'];
            $divMin = $request['filterDiv2'];
        }

        //Valida se usuário possui permissão para acessar esta opção
        if (App\Models\User::getPermission('documents_inv_item_add', Auth::user()->user_type_code)) {
            $document = $this->documentRepository->findWithoutFail($document_id);

            //Pega todos os saldos para montar a tela de itens
            $invItems = App\Models\InventoryItem::getItensForCount($document->id, $invCount, $deposits, $divMax, $divMin);

            return view('modules.inventory.selectItemsNextCount')->with('document', $document)
                ->with('invItems', $invItems)
                ->with('depositAnt', '')
                ->with('invCount', $invCount);
        } else {
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('inventory'));
        }
    }

    /**
     * Atualiza os itens para a próxima contagem e finaliza os que foram selecionados
     *
     * @return Response
     */

    public function updateItemsNextCount($document_id, Request $request)
    {
        $input = $request->all();
        $invCount = $input['invCount'];

        foreach ($input['items'] as $code => $type) {
            $res = explode('+', $code); //o Código vem no formato produto + endereço
            $location = $res[0];
            $prod = $res[1];
            if (trim($location) <> '' && trim($prod) <> '') {
                if ($type == 'F') {
                    //Finaliza
                    //echo 'Fim : '.$prod.' // '.$location.' -- ';
                    $ret = App\Models\InventoryItem::closeItem($document_id, $prod, $location, $invCount);
                } elseif ($type == 'P') {
                    //Próxima contagem
                    $ret = App\Models\InventoryItem::nextCount($document_id, $prod, $location, $invCount);
                }
            }
        }
        //Valida se todos os itens pendentes foram finalados para passar para a proxima contagem
        $invItems = App\Models\InventoryItem::getItensForCount($document_id, $invCount);
        if (count($invItems) == 0) {
            //Muda status do documento para prox contagme
            $document = App\Models\Document::find($document_id);
            $document->inventory_status_id = $invCount;
            $document->save();

            //Itens atualizados com sucesso. Prox contagem liberada
            Flash::success(Lang::get('validation.inv_items_next', ['count' => $invCount]));
        } else {
            //Itens atualizados com sucesso
            Flash::success(Lang::get('validation.inv_items_close'));
        }

        return redirect(url('inventory'));
    }

    /**
     * Detalha os itens para finalziar a contagem (Retorna palete, etiqueta e qdes)
     *
     * @return Response
     */

    public function detItemsNextCount($document_id, Request $request)
    {
        $input = $request->all();
        //$invCount = $input['invCount'];
        $product = $input['product'];
        $location = $input['location'];
        $invCount = $input['count'];

        $det =  App\Models\InventoryItem::getDetItensForCount($document_id, $product, $location, $invCount);
        return $det;
    }


    /**
     * Finaliza Documento de Inventário
     *
     * @return Response
     */

    public function finalize($document_id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if (App\Models\User::getPermission('documents_inv_fin', Auth::user()->user_type_code)) {
            //Finaliza os itens no Inventário
            if (App\Models\InventoryItem::closeItems($document_id)) {
                //Finaliza Documento
                $retorno = App\Models\Document::finalizeInventory($document_id);
                $descricao = 'Finalizou inventario';
                $log = App\Models\Log::wlog('documents_inv_fin', $descricao, $document_id);
                Flash::success("Documento Finalizado com Sucesso");
                return array('success', "Documento Finalizado com Sucesso");
            } else {
                Flash::error(Lang::get('validation.val_error'));
                return redirect(url('inventory'));
            }
        } else {
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('inventory'));
        }
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
        return view('modules.inventory.gridItem')->with('document', $document);
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
            $deposits = (empty($input['deposits'])) ? '' : $input['deposits'];
        } else {
            //Se não informou depósitos por padrão, não lista nada
            $deposits = 'DEP01,DEP02,';
        }

        //Valida se usuário possui permissão para acessar esta opção
        if (App\Models\User::getPermission('documents_inv_item_add', Auth::user()->user_type_code)) {
            $document = $this->documentRepository->findWithoutFail($document_id);

            //Pega todos os saldos para montar a tela de itens
            $stocks = App\Models\Stock::getStockInv($deposits, $document->id);

            return view('modules.inventory.selectItems')->with('document', $document)
                ->with('stocks', $stocks)
                ->with('depositAnt', '');
        } else {
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
        foreach ($input['items'] as $detailItem) {
            //Quebra as informações pelo caractere '+', que separa o endereço do produto
            $detail = explode('+', $detailItem);
            //Pega saldos do produto + endereço
            $stocks = App\Models\Stock::getStock($detail[0], $detail[1], 2);
            //Loop nos saldos
            foreach ($stocks as $stock) {
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

        return redirect(url('inventory/' . $document_id . '/selectItems'));
    }

    /**
     * Mostra o formulário para edição de itens em um documento de inventário
     *
     * @return Response
     */

    public function editItem($document_id, $document_item_id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if (App\Models\User::getPermission('documents_inv_item_edit', Auth::user()->user_type_code)) {

            $document = $this->documentRepository->findWithoutFail($document_id);
            $document_item = $this->documentItemRepository->findWithoutFail($document_item_id);

            return view('modules.inventory.editItem')->with('document', $document)
                ->with('documentItem', $document_item);
        } else {
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('inventory/' . $input['document_id'] . '/items'));
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
        } else {
            //Grava log
            $requestF = $request->all();
            $descricao = 'Alterou Item ID: ' . $id . ' - ' . $requestF['product_code'] . ' - ' . $requestF['qty'] . ' ' . $requestF['uom_code'] . ' - Lote: ' . $requestF['batch'] . ' //Doc_ID: ' . $requestF['document_id'];
            $log = App\Models\Log::wlog('documents_inv_item_edit', $descricao);


            $documentItem = $this->documentItemRepository->update($request->all(), $id);

            Flash::success(Lang::get('validation.update_success'));
        }

        return redirect(url('inventory/' . $requestF['document_id'] . '/items'));
    }

    /**
     * Retorna Contagens de Um Endereço
     *
     * @param CreateDocumentRequest $request
     *
     * @return Response
     */
    public function returnLocation($document_id, $location_code)
    {

        $document = $this->documentRepository->findWithoutFail($document_id);

        //Valida se usuário possui permissão para acessar esta opção
        if (App\Models\User::getPermission('documents_inv_ret', Auth::user()->user_type_code)) {
            $return = App\Models\InventoryItem::returnLocation($document_id, $location_code, $document->inventory_status_id);

            if ($return['erro'] == 0) {
                //Grava Logs
                $descricao = 'Retornou Contagens do Endereço: ' . $location_code;
                $log = App\Models\Log::wlog('documents_inv_ret', $descricao, $document_id);

                return array('success', Lang::get('infos.return_location', ['location' =>  $location_code]));
            } else {
                //Erro ao retornar
                return array('danger', $return['msg']);
            }
        } else {
            //Sem permissão
            //Flash::error(Lang::get('validation.permission'));
            return array('danger', Lang::get('validation.permission'));
        }
    }

    /**
     * Retorna Contagens de Um Endereço
     *
     * @param CreateDocumentRequest $request
     *
     * @return Response
     */
    public function audit($document_id, $location_code)
    {

        //Valida se usuário possui permissão para acessar esta opção
        if (App\Models\User::getPermission('documents_inv_ret', Auth::user()->user_type_code)) {
            $document = $this->documentRepository->findWithoutFail($document_id);
            return view('modules.inventory.gridAudit')
                ->with('document', $document)
                ->with('location_code', $location_code);
        } else {
            //Sem permissão
            //Flash::error(Lang::get('validation.permission'));
            return array('danger', Lang::get('validation.permission'));
        }
    }


    public function getItems($document_id)
    {
        $documents = App\Models\DocumentItem::where('document_id', $document_id)->get();
        return $documents->toArray();
    }

    public function auditLocation($document_id, AuditLocationRequest $request)
    {
        // print_r($request->all());exit;
        $inputs = $request->all();
        //Valida se usuário possui permissão para acessar esta opção
        if (App\Models\User::getPermission('documents_inv_audit', Auth::user()->user_type_code)) {

            foreach ($inputs as $chave => $valor) {
                if (!in_array($chave, ["_token","number", "location_code", "document_type_code"])) {
                    $inventory_item_id = $chave;
                    $novoValor = $valor;
                    //Pega Inventory Item e Task
                    $invItm = InventoryItem::find($inventory_item_id);
                    // echo $inventory_item_id;exit;
                    if($invItm->qty_1count == $novoValor){
                        continue;
                    }
                    $task = Task::where([
                        ['company_id', Auth::user()->company_id],
                        ['inventory_item_id', $inventory_item_id],
                        ['document_id', $document_id],
                        ['operation_code', "551"]
                    ])->first();
                    $description = "Item ajustado: " . $invItm->qty_1count . " -> " . $novoValor;
                    //Cria atividade
                    Activity::create(
                        $task->id,
                        $invItm->product_code,
                        $invItm->label_id,
                        $invItm->pallet_id,
                        $novoValor,
                        $description,
                        $document_id,
                        NULL,
                        $invItm->location_code,
                        NULL,
                        $inventory_item_id,
                        8,
                        1,
                        NULL,
                        Auth::id()
                    );
                    //Salva Inventory Item
                    $invItm->qty_1count = $novoValor;
                    $invItm->save();
                }
            }
            $descricao = 'Auditoria Documento ID: ' . $document_id . ' - ' . $inputs['document_type_code'] . ' ' . $inputs['number'] . ' - Endereço: ' . $inputs['location_code'];
            $log = App\Models\Log::wlog('documents_inv_audit', $descricao, $document_id);
            Flash::success(Lang::get('infos.audit_location', ['location' =>  $inputs['location_code']]));
            $document = $this->documentRepository->findWithoutFail($document_id);
            return view('modules.inventory.gridItem')->with('document', $document);

            
        } else {
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            $document = $this->documentRepository->findWithoutFail($document_id);
            return view('modules.inventory.gridItem')->with('document', $document);
        }
    }
}
