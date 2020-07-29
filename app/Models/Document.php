<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App;
use DB;
use Lang;

class Document extends Model
{

    protected $table = 'documents';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['created_at','updated_at','emission_date','start_date','end_date','billing_date', 'delivery_date'];


    protected $fillable = [
        'id',
        'company_id',
        'number',
        'customer_code',
        'supplier_code',
        'courier_code',
        'invoice',
        'serial_number',
        'emission_date',
        'start_date',
        'end_date',
        'delivery_date',
        'billing_date',
        'wave',
        'total_volumes',
        'total_weight',
        'document_status_id',
        'total_net_weigth',
        'driver_id',
        'vehicle_id',
        'priority',
        'comments',
        'document_type_code',
        'user_id',
        'location_code',
        'number_origin',
        'document_type_origin',
        'finalization',
        'inventory_status_id',
        'inventory_value',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'number' => 'string',
        'company_id' => 'integer',
        'document_type_code' => 'string',
        'document_status_id' => 'integer',
        'customer_code' => 'string',
        'courier_code' => 'string',
        'supplier_code' => 'string',
        'location_code' => 'string',
        'number_origin' => 'string',
        'document_type_origin' => 'string',
        'finalization' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
    
    /**
     * Função que retorna todos os documentos de um tipo de movimento
     * Parâmetros: Código do Movimento e quantidade de documentos para retornar
     * @var array
     */

    public static function getDocuments($moviment_code, $qty){
        $docs = Document::select('documents.id','documents.company_id','documents.number','document_type_code',DB::raw("CONCAT(customer_code,' - ',customers.trading_name) as customer"),
                                  DB::raw("CONCAT(supplier_code,' - ',suppliers.trading_name) as supplier"),DB::raw("CONCAT(courier_code,' - ',couriers.trading_name) as courier"),
                                  'vehicle_id','driver_id','documents.invoice','documents.serial_number','emission_date','start_date','end_date','wave','total_volumes','total_weight',
                                 'documents.document_status_id','total_net_weigth','priority','comments','user_id',
                                 'documents.created_at','documents.updated_at','moviment_code', 'document_status.description',
                                 'inventory_status.description as inv_description', 'inventory_status_id', DB::raw("COUNT(DISTINCT document_items.id) as total_items"),
                                 DB::raw("IFNULL(ROUND(SUM(CASE WHEN document_items.qty_conf IS NULL THEN 0 ELSE document_items.qty_conf END)/SUM(document_items.qty)*100,0),0) as total_conf"),
                                 'documents.delivery_date','documents.billing_date', 'document_types.lib_location', 'document_types.print_labels','document_types.label_type_code',
                                 'document_types.print_labels_doc','documents.location_code', 'documents.number_origin', 'documents.document_type_origin','documents.finalization',
                                 'documents.inventory_value')
                        ->join('document_types', 'documents.document_type_code', '=', 'document_types.code')
                        ->join('document_status', 'document_status.id', '=', 'documents.document_status_id')
                        ->leftJoin('customers', function ($joint) {
                            $joint->on('customers.code', '=', 'documents.customer_code')
                                 ->whereColumn('customers.company_id','documents.company_id');
                        })
                        ->leftJoin('suppliers', function ($join) {
                            $join->on('suppliers.code', '=', 'documents.supplier_code')
                                 ->whereColumn('suppliers.company_id','documents.company_id');
                        })
                        ->leftJoin('couriers', function ($join) {
                            $join->on('couriers.code', '=', 'documents.courier_code')
                                 ->whereColumn('couriers.company_id','documents.company_id');
                        })
                        ->leftJoin('inventory_status', 'inventory_status.id', '=', 'documents.inventory_status_id')
                        ->leftJoin('document_items', function ($join) {
                            $join->on('documents.id', '=', 'document_items.document_id')
                                 ->where('document_items.document_status_id','<>', 9);
                        })
                       ->where([
                                 ['documents.company_id', Auth::user()->company_id],
                                 ['document_types.moviment_code', $moviment_code]                        
                       ])
                       ->groupBy('documents.id','documents.company_id','documents.number','document_type_code','customer_code',
                                'supplier_code','courier_code','vehicle_id','driver_id','invoice','serial_number',
                                'emission_date','start_date','end_date','wave','total_volumes','total_weight',
                                'document_status_id','total_net_weigth','priority','comments','user_id',
                                'documents.created_at','documents.updated_at','moviment_code', 'document_status.description',
                                'inventory_status.description', 'inventory_status_id',  'document_types.lib_location', 'document_types.print_labels',
                                'documents.delivery_date','documents.billing_date','document_types.label_type_code','document_types.print_labels_doc',
                                'documents.location_code', 'documents.number_origin', 'documents.document_type_origin','documents.finalization',
                                'documents.inventory_value')
                       ->orderBy('documents.id', 'desc')
                       ->take($qty)
                       ->get();
        return $docs;
    }

    /**
     * Função que valida se o número de documento + tipo já existe (Para criação e importação)
     * Parâmetros: Tipo e Número do documento
     * @var array
     */

    public static function valDocumentNumber($document_type_code, $number){
        //Número só é valido se não existir nenhum documento com status <> 7, 8  e 9
        $docCount = Document::where([
                                 ['company_id', Auth::user()->company_id],
                                 ['document_type_code', $document_type_code],
                                 ['number', $number]
                            ])
                            ->whereNotIn('document_status_id',['7','8','9','12'])
                            ->count();
        return $docCount;
    }


    /**
     * Função que libera o documento encaminhando para as regras corretas de acordo com o tipo
     * Parâmetros: Informações do(s) Documento(s) (id, moviment_code, document_type_code, etc.)
     * @var array
     */

    public static function liberate($documents, $module, $isWave = 0, $location_code = ''){
        
        //Busca qual a classe e o retorno para buscar as regras de liberação 
        $rc = App\Models\Moviment::getClass($documents[0]['moviment_code']);
            
        if($rc){
            $class = $rc['class'];
            $urlRet = $rc['urlRet'];
        }else{
            $return['erro'] = 1;
            $return['msg'] = 'Não foram encontradas regras para este movimento!';
            return $return;
        }

        $documentIds = array();

        DB::beginTransaction();

        //Endereço destino na variável de sessão para ser utilizada no arquivo de regras
        $_SESSION['location_code_lib'] = $location_code;

        foreach($documents as $doc){
            $erro = 0;
            $entrou = 0;
            $document_id = $doc['id'];
            $documentIds[] = $doc['id'];

            //Busca todas as regras disponíveis para o tipo de documento
            $rules = App\Models\DocumentTypeRule::where([
                                                            ['company_id', Auth::user()->company_id],
                                                            ['document_type_code', $doc['document_type_code']],
                                                 ])
                                                 ->orderBy('order', 'asc')
                                                 ->get()
                                                 ->toArray();

                                       
            foreach($rules as $rule){
                $entrou = 1;
                $rule_code = $rule['liberation_rule_code'];
                //Valida se existe a função com esse nome/código na classe correspondente
                if(method_exists(new $class(),$rule_code)){
                    //Chama a regra correspondente
                    $return = $class::$rule_code($document_id);
                    if($return['erro'] <> 0){
                        //Erro ao executar a regra
                        $return['msg'] .= ' - Documento: '.$doc['number'];
                        $erro = 1;
                        break;
                    }
                }else{
                    $erro = 1;
                    $return['msg'] = 'Regra '.$rule_code.' não existe no arquivo de liberação.';
                }
            }

            

            //Se não tem regras, da erro
            if($entrou == 0){
                $erro = 1;
                $return['erro'] = 1;
                $return['msg'] = 'Sem regras cadastradas para o Tipo de Documento '.$doc['document_type_code'].'.';
                //Sai do loop
                break;
            }else if($erro == 1){
                //Sai do loop
                break;
                $return['erro'] = 1;
            }else{
                //Sem erros, grava log e libera o doc com o endereço destino no campo location_code
                $descricao = 'Liberou o documento: '.$doc['document_type_code'].' - '.$doc['number'];
                $log = App\Models\Log::wlog('documents_'.$module.'_lib', $descricao, $document_id);

                $updDoc = Document::where('company_id', Auth::user()->company_id)
                                   ->where('id', $document_id)
                                   ->where('document_status_id', 0)
                                   ->update(['document_status_id' => 1,
                                             'location_code' => $location_code]);

            }
            
        }


        if($erro == 0){
            //Sem Erros
            //Valida se é ONDA
            if($isWave == 1){
                //Função que retorna o tipo de documento a ser gerado em liberação por onda
                //Se não estiver preenchido, apenas será gerado o número da onda no campo wave(documents)
                $docWave = Moviment::getDocWave($documents[0]['moviment_code']); 
                $wave = date('Ymdhis');

                //Se for onda, atualiza o campo em todos os documentos
                $updDocs = Document::where('company_id', Auth::user()->company_id)
                                   ->whereIn('id', $documentIds)
                                   ->update(['wave' => $wave]);

                 //Grava log
                $descricao = 'Liberou Onda: '.$wave;
                $log = App\Models\Log::wlog('documents_'.$module.'_lib', $descricao);

                $return['msg'] = 'Onda '.$wave.' liberada com sucesso!';

            }else{
                $return['msg'] = 'Documento '.$documents[0]['number'].' liberado com sucesso!';
            }
            $return['erro'] = 0;

            //Deu tudo certo, da o commit
            DB::commit();

        }else{
            //Desfaz tudo que foi feito e retorna a msg de erro
            DB::rollBack();
        }

        unset($_SESSION['location_code_lib']);

        return $return;

    }

    /**
     * Função que libera o documento de inventário
     * Parâmetros: ID do Documento , Contagem
     * @var array
     */

    public static function liberateInventory($document_id, $cont = 1){
        //Busca documento
        $doc = App\Models\Document::find($document_id);
        if(in_array($doc->document_type_code, array('IVD','IVG','IVR','INV'))){
            //Define status da inventory_item e a tarefa baseado na contagem
            switch($cont){
                case 1:
                    $operation_code = "551";
                    $status = 1;
                break;
                case 2:
                    $operation_code = "552";
                    $status = 2;
                break;
                case 3:
                    $operation_code = "553";
                    $status = 3;
                break;
                case 4:
                    $operation_code = "554";
                    $status = 4;
                break;
            }

            

            //Pega itens inseridos no inventario
            $items = App\Models\InventoryItem::getItens($document_id);

            foreach($items as $item){
                //Primeira contagem cria as linhas EM INVENTARIO
                if($cont == 1){
                    $newStock = new Stock($item);
                    $newStock['operation_code'] = '550';
                    $newStock['prim_qty'] = $newStock['qty'];
                    $newStock['prim_uom_code'] = $newStock['uom_code'];
                    $newStock['label_id'] = NULL;
                    $newStock['pallet_id'] = NULL;
                    $stock = App\Models\Stock::updStock($newStock->toArray(), 'INVENTARIO');
                }

                //Cria uma tarefa para cada item / endereço
                $task = App\Models\Task::create("$operation_code","{$item['location_code']}" ,"{$item['location_code']}", $document_id, NULL,$item['id'] );
                
                
            }

            //Atualiza todos os itens para o status da contagem
            $upInv = DB::table('inventory_items')->where([  
                        ['company_id', Auth::user()->company_id],
                        ['document_id', $document_id],
                        ['inventory_status_id','<>','8'],
                        ['inventory_status_id','<>','9']
            ])->update(['inventory_status_id' => $status]);

            //Muda Status do Documento para liberado e contagem liberada
            $doc->document_status_id = 1;
            $doc->inventory_status_id = $status;
            $doc->save();

            $return['erro'] = 0;
            $return['msg'] = 'Inventário Liberado com Sucesso';
        }else{
            $return['erro'] = 1;
            $return['msg'] = 'Tipo de Documento Inválido para esta Operação.';
        }

        return $return;

    }


    /**
     * Função que retorna o documento de inventário
     * Parâmetros: ID do Documento
     * @var array
     */

    public static function returnInventory($document_id){
        //Busca documento
        $doc = App\Models\Document::find($document_id);
        if(in_array($doc->document_type_code, array('IVD','IVG','IVR','INV'))){
            //Só permite retornar com status de contagens pendentes
            if(in_array($doc->inventory_status_id, array(1,2,3,4))){

                //Atualiza todos os itens para o status pendente
                $upInv = DB::table('inventory_items')->where([  
                    ['company_id', Auth::user()->company_id],
                    ['document_id', $document_id]
                ])->update(['inventory_status_id' => 0,
                            'qty_1count' => 0,
                            'qty_2count' => 0,
                            'qty_3count' => 0,
                            'qty_4count' => 0,
                            'user_1count' => NULL,
                            'user_2count' => NULL,
                            'user_3count' => NULL,
                            'user_4count' => NULL]);
                
                //Volta status do documento
                $upTsk = DB::table('documents')->where([  
                    ['company_id', Auth::user()->company_id] ,
                    ['id', $document_id]
                ])->update(['document_status_id' => 0,
                            'inventory_status_id' => 0]);

                //Cancela todas as tarefas
                $upTsk = DB::table('tasks')->where([  
                    ['company_id', Auth::user()->company_id] ,
                    ['document_id', $document_id],
                ])->update(['task_status_id' => 9]);

                //Apaga linhas em Inventário
                $dSal = DB::table('stocks')->where([  
                    ['company_id', Auth::user()->company_id],
                    ['document_id', $document_id],
                    ['finality_code', 'INVENTARIO']
                ])->delete();

                $return['erro'] = 0;
                $return['msg'] = 'Inventário Retornado com Sucesso';

            }else{
                $return['erro'] = 1;
                $return['msg'] = 'Status de Inventário Inválido para esta Operação.';
            }
        }else{
            $return['erro'] = 1;
            $return['msg'] = 'Tipo de Documento Inválido para esta Operação.';
        }

        return $return;

    }
    /**
     * Função que retorna o documento para pendente
     * Parâmetros: ID dos Documentos
     * @var array
     */

    public static function return($documents, $module){

        $documentIds = array();

        DB::beginTransaction();
        //Loop nos documentos passados como parâmetro
        foreach($documents as $doc){
            $erro = 0;
            $entrou = 0;
            $document_id = $doc['id'];
            $documentIds[] = $doc['id'];

            //Busca documento
            $docT = App\Models\Document::find($document_id);

            if(!empty($docT)){
                $docT->document_status_id = 0;
                $docT->location_code = NULL;
                $docT->wave = NULL;
                $docT->save();
                //Apaga informaçoes da tabela de liberação
                $rLb = DB::table('liberation_items')->where([  
                                                            ['company_id', Auth::user()->company_id],
                                                            ['document_id', $document_id]
                                                ])->delete();

                //Apaga reservas criadas para o documento  
                $rSt = DB::table('stocks')->where([  
                                                            ['company_id', Auth::user()->company_id],
                                                            ['document_id', $document_id],
                                                            ['finality_code', 'RESERVA']
                                                    ])->delete();     
                
                //Apagar tarefas não iniciadas
                $uTsk = DB::table('tasks')->where([  
                                                    ['company_id', Auth::user()->company_id],
                                                    ['document_id', $document_id],
                                                    ['task_status_id', '<', 2]
                                                 ])->delete();     
                                                                                            
                //Grava log
                $descricao = 'Retornou o documento: '.$docT->document_type_code.' - '.$docT->number;
                $log = App\Models\Log::wlog('documents_'.$module.'_ret', $descricao, $document_id);
            }else{
                $erro = 1;
                break;
                $return['erro'] = 1;
                $return['msg'] = 'Documento ID('.$document_id.') não encontrado.';
            }
        }

        if($erro == 0){
            $return['erro'] = 0;
            //Valida se apenas um documento foi passado como parametro
            if(count($documents) == 1){
                $return['msg'] = Lang::get('infos.return_doc',  ['doc' =>  $docT->number]);
            }else{
                $return['msg'] = Lang::get('infos.return_docs');
            }
            DB::commit();
        }else{
            DB::rollback();
        }
        
        return $return;
        
    }

    /**
     * Função que cancela um documento
     * Parâmetros: ID dos Documentos
     * @var array
     */

    public static function cancel($documents, $module){

        $documentIds = array();

        DB::beginTransaction();
        //Loop nos documentos passados como parâmetro
        foreach($documents as $doc){
            $erro = 0;
            $entrou = 0;
            $document_id = $doc['id'];
            $documentIds[] = $doc['id'];

            //Busca documento
            $docT = App\Models\Document::find($document_id);

            if(!empty($docT)){
                //Cancela o status
                $docT->document_status_id = 9;
                $docT->save();
                //Apaga informaçoes da tabela de liberação
                $rLb = DB::table('liberation_items')->where([  
                                                            ['company_id', Auth::user()->company_id],
                                                            ['document_id', $document_id]
                                                ])->delete();

                //Apaga reservas criadas para o documento  
                $rSt = DB::table('stocks')->where([  
                                                            ['company_id', Auth::user()->company_id],
                                                            ['document_id', $document_id],
                                                            ['finality_code', 'RESERVA']
                                                    ])->delete();     
                //Cancela tarefas 
                $rSt = DB::table('tasks')->where([  
                                                    ['company_id', Auth::user()->company_id],
                                                    ['document_id', $document_id],
                                                    ['task_status_id', '<>', '8']
                                         ])->update(['task_status_id' => '9']);                                                         
                //Grava log
                $descricao = 'Cancelou o documento: '.$docT->document_type_code.' - '.$docT->number;
                $log = App\Models\Log::wlog('documents_'.$module.'_cancel', $descricao,$document_id);
            }else{
                $erro = 1;
                break;
                $return['erro'] = 1;
                $return['msg'] = 'Documento ID('.$document_id.') não encontrado.';
            }
        }

        if($erro == 0){
            $return['erro'] = 0;
            //Valida se apenas um documento foi passado como parametro
            if(count($documents) == 1){
                $return['msg'] = Lang::get('infos.cancel_doc',  ['doc' =>  $docT->number]);
            }else{
                $return['msg'] = Lang::get('infos.cancel_docs');
            }
            DB::commit();
        }else{
            DB::rollback();
        }
        
        return $return;
        
    }

    /**
     * Função que finaliza o documento de inventário
     * Parâmetros: ID do Documento
     * @var array
     */

    public static function finalizeInventory($document_id){
        //Busca documento
        $doc = App\Models\Document::find($document_id);
        if(in_array($doc->document_type_code, array('IVD','IVG','IVR','INV'))){
            //Só permite finalizar se a primeira contagem estiver iniciada
            if($doc->inventory_status_id > 1){

                //Atualiza todos os itens para o status pendente
                $upInv = DB::table('inventory_items')->where([  
                    ['company_id', Auth::user()->company_id],
                    ['document_id', $document_id]
                ])->update(['inventory_status_id' => 8,
                            'qty_1count' => 0,
                            'qty_2count' => 0,
                            'qty_3count' => 0,
                            'qty_4count' => 0,
                            'user_1count' => NULL,
                            'user_2count' => NULL,
                            'user_3count' => NULL,
                            'user_4count' => NULL]);
                
                //Volta status do documento
                $upTsk = DB::table('documents')->where([  
                    ['company_id', Auth::user()->company_id] ,
                    ['id', $document_id]
                ])->update(['document_status_id' => 0,
                            'inventory_status_id' => 0]);

                //Cancela todas as tarefas
                $upTsk = DB::table('tasks')->where([  
                    ['company_id', Auth::user()->company_id] ,
                    ['document_id', $document_id],
                ])->update(['task_status_id' => 8]);

                //Apaga linhas em Inventário
                $dSal = DB::table('stocks')->where([  
                    ['company_id', Auth::user()->company_id],
                    ['document_id', $document_id],
                    ['finality_code', 'INVENTARIO']
                ])->delete();

                $return['erro'] = 0;
                $return['msg'] = 'Inventário Retornado com Sucesso';

            }else{
                $return['erro'] = 1;
                $return['msg'] = 'Status de Inventário Inválido para esta Operação.';
            }
        }else{
            $return['erro'] = 1;
            $return['msg'] = 'Tipo de Documento Inválido para esta Operação.';
        }

        return $return;

    }

    /**
     * Função que retorna informações para impressão (em formato de array)
     *
     * @param document_id
     * @var array
     */
    public static function getInfosForPrint($document_id){

       $infos = Document::select('documents.id as documents.id','documents.company_id as documents.company_id',
                                 'documents.number as documents.number','document_type_code as documents.document_type_code',
                                 'documents.invoice as documents.invoice','documents.serial_number as documents.serial_number',
                                 'emission_date as documents.emission_date','start_date as documents.start_date',
                                 'end_date as documents.end_date', 'wave as documents.wave','total_volumes as documents.total_volumes',
                                 'total_weight as documents.total_weight','documents.document_status_id as documents.document_status_id',
                                 'total_net_weigth as documents.total_net_weigth','priority as documents.priority','comments as documents.comments',
                                 'documents.obs1 as documents.obs1','documents.obs2 as documents.obs2','documents.obs3 as documents.obs3',
                                 'documents.user_id as documents.user_id','document_status.description','delivery_date as documents.delivery_date',

                                 'customer_code as documents.customer_code','customers.name as customers.name',
                                 'customers.trading_name as customers.trading_name','customers.cnpj as customers.cnpj',
                                 'customers.state_registration as customers.state_registration','customers.address as customers.address',
                                 'customers.number as customers.number','customers.neighbourhood as customers.neighbourhood',
                                 'customers.city as customers.city','customers.state as customers.state',
                                 'customers.country as customers.country','customers.state as customers.zip_code',
                                 'customers.phone1 as customers.phone1','customers.phone2 as customers.phone2',

                                 'supplier_code as documents.supplier_code','suppliers.name as suppliers.name',
                                 'suppliers.trading_name as suppliers.trading_name','suppliers.cnpj as suppliers.cnpj',
                                 'suppliers.state_registration as suppliers.state_registration','suppliers.address as suppliers.address',
                                 'suppliers.number as suppliers.number','suppliers.neighbourhood as suppliers.neighbourhood',
                                 'suppliers.city as suppliers.city','suppliers.state as suppliers.state',
                                 'suppliers.country as suppliers.country','suppliers.state as suppliers.zip_code',
                                 'suppliers.phone1 as suppliers.phone1','suppliers.phone2 as suppliers.phone2',

                                 'courier_code as documents.courier_code','couriers.name as couriers.name',
                                 'couriers.trading_name as couriers.trading_name','couriers.cnpj as couriers.cnpj',
                                 'couriers.state_registration as couriers.state_registration','couriers.address as couriers.address',
                                 'couriers.number as couriers.number','couriers.neighbourhood as couriers.neighbourhood',
                                 'couriers.city as couriers.city','couriers.state as couriers.state',
                                 'couriers.country as couriers.country','couriers.state as couriers.zip_code',
                                 'couriers.phone1 as couriers.phone1','couriers.phone2 as couriers.phone2',

                                 'drivers.name as drivers.name','drivers.license as drivers.license','drivers.phone as drivers.phone',

                                 'vehicles.number_plate as vehicles.number_plate',

                                 DB::raw("COUNT(DISTINCT document_items.id) as total_items"),
                                 DB::raw("SUM(document_items.qty) as total_qty"),
                                 DB::raw("ROUND(SUM(CASE WHEN document_items.qty_conf IS NULL THEN 0 ELSE document_items.qty_conf END)/SUM(document_items.qty)*100,0) as total_conf"))
                        
                        ->join('document_types', 'documents.document_type_code', '=', 'document_types.code')
                        ->join('document_status', 'document_status.id', '=', 'documents.document_status_id')
                        ->leftJoin('inventory_status', 'inventory_status.id', '=', 'documents.inventory_status_id')
                        ->leftJoin('document_items', function ($join) {
                            $join->on('documents.id', '=', 'document_items.document_id')
                                 ->where('document_items.document_status_id','<>', 9);
                        })
                        ->leftJoin('customers', function ($join) {
                            $join->on('customers.code','documents.customer_code')
                                ->whereColumn('customers.company_id','documents.company_id');
                        })
                        ->leftJoin('suppliers', function ($join) {
                            $join->on('suppliers.code','documents.supplier_code')
                                ->whereColumn('suppliers.company_id','documents.company_id');
                        })
                        ->leftJoin('couriers', function ($join) {
                            $join->on('couriers.code','documents.courier_code')
                                ->whereColumn('couriers.company_id','documents.company_id');
                        })
                        ->leftJoin('drivers', 'drivers.id', 'documents.driver_id')
                        ->leftJoin('vehicles', 'vehicles.id', 'documents.vehicle_id')
                        ->where([
                                 ['documents.company_id', Auth::user()->company_id],
                                 ['documents.id', $document_id]                        
                        ])
                       ->groupBy('documents.id','documents.company_id','documents.number','documents.document_type_code',
                                 'customer_code','supplier_code','courier_code','number_plate','drivers.name','drivers.license',
                                 'drivers.license','documents.invoice','documents.serial_number','documents.emission_date','documents.start_date','end_date','wave',
                                 'total_volumes','total_weight','documents.document_status_id','total_net_weigth','priority','documents.comments',
                                 'documents.user_id','document_status.description','documents.obs1','documents.obs2','documents.obs3',
                                 'customers.name','customers.trading_name','customers.cnpj','customers.state_registration',
                                 'customers.address','customers.number','customers.neighbourhood', 'customers.zip_code', 
                                 'customers.phone1','customers.phone2','customers.country','customers.state','customers.city',
                                 'couriers.name','couriers.trading_name','couriers.cnpj','couriers.state_registration',
                                 'couriers.address','couriers.number','couriers.neighbourhood', 'couriers.zip_code', 
                                 'couriers.phone1','couriers.phone2','couriers.country','couriers.state','couriers.city',
                                 'suppliers.name','suppliers.trading_name','suppliers.cnpj','suppliers.state_registration',
                                 'suppliers.address','suppliers.number','suppliers.neighbourhood', 'suppliers.zip_code', 
                                 'suppliers.phone1','suppliers.phone2','suppliers.country','suppliers.state','suppliers.city',
                                 'documents.delivery_date')
                       ->orderBy('documents.id', 'desc')
                       ->get();
        
        //Formata os campos de data
        
        //$infos->start_date->format('d/m/Y'); //Data de Inicio
        //$infos->{'documents.end_date'}->format('d/m/Y'); //Data de Finalização
        //$infos->{'documents.emission_date'}->format('d/m/Y'); //Data de Emissão
        //$infos->{'documents.delivery_date'}->format('d/m/Y'); //Data de Entrega
        //$infos->delivery_date->format('d/m/Y'); //Data de Entrega

        return $infos;

    }

    
}
