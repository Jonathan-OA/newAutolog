<?php

namespace App\Imports;
use Auth;
use DB;
use Maatwebsite\Excel\Concerns\ToArray;

class InventoryItemsImport implements ToArray
{
    private $parameters = '';
    private $customer_code = '';
    private $value = '';
    private $billing_type = '';
    private $fieldsOrderJson = '';
    private $documentNumber = '';

    //Parametros de inventário enviados pelo construtor no controller de inventário
    //Customer = Cliente e Value = Valor por Leitura
    public function __construct($parameters, $customer, $value, $billing_type, $fieldsOrderJson, $documentNumber = ""){
        $this->parameters = $parameters;
        $this->customer_code = $customer;
        $this->value = $value;
        $this->billing_type = $billing_type;
        $this->fieldsOrderJson = $fieldsOrderJson; //Ordem dos campos para importação
        $this->documentNumber = $documentNumber; //Número do documento para casos de reimportação
    }

    

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function array($row, $params = "")
    {   
        //Desabilita logs do banco para amenizar o uso de cpu
        DB::connection()->disableQueryLog();

        //Arrays para realizar os inserts de uma vez só
        $arrayInsertPrd = array();
        $arrayInsertPack = array();
        $arrayInsertBcd = array();
        $arrayInsertEnd = array();
        $arrayInsertDep = array();
        $arrayInsertUom = array();

        $isTxt = true;
        $inventoryNumber = "";

        //Sem parâmetros informados (Array(separator e order))
        if(empty($params)){
            $erro = 1;
            return $erro;
        }else{
            $separator = $params['separator'];
            $order = $params['order'];
        }

        $cont = 0;
        $erro = 0;
        $arrayErrors = array();

        DB::beginTransaction();
        
        while ($line = fgetcsv($row, 0, $separator)) {
            $cont++;
            
            if(count($line) == 0) break; //Ultima linha vazia
            
            $endere = ($isTxt) ? ((array_key_exists('end', $order)) ? $line[$order['end']] : '') : $line[0];
            $deposito = ($isTxt) ? ((array_key_exists('dep', $order)) ? $line[$order['dep']] : '') : $line[1];
            $produto = ($isTxt) ? ((array_key_exists('prd', $order)) ? strtoupper($line[$order['prd']]) : '') : $line[2];
            $desc = ($isTxt) ? ((array_key_exists('dsc', $order)) ? $line[$order['dsc']] : '') : $line[3];
            $barcode = ($isTxt) ? ((array_key_exists('ean', $order)) ? strtoupper($line[$order['ean']]) : '') : $line[4];
            $saldo = ($isTxt) ? ((array_key_exists('qde', $order)) ? $line[$order['qde']] : null) : $line[5];
            $unidade = ($isTxt) ? ((array_key_exists('uni', $order)) ? $line[$order['uni']] : '') : $line[6];

            //Se Chegou até aqui, porém EAN ta preenchido mas Código do Produto não, Código do Produto fica igual ao EAN
            if(!(array_key_exists('prd', $order)) && ($produto == "" && $barcode <> "")){
                $produto = $barcode;
            }

            //Se Chegou até aqui, porém PRD ta preenchido mas Barcode não, Código do Produto fica igual ao EAN
            if(array_key_exists('ean', $order) && ($barcode == "" && $produto <> "")){
                $barcode = $produto;
            }
            

            //Primeira linha
            if($cont == 1) {
                //Se não entrou como parâmetro o número do inventário, cria
                if(trim($this->documentNumber) == ''){

                    //Valida quantos foram criados na data atual e incrementa 
                    $cInv = \App\Models\Document::where('company_id',Auth::user()->company_id)
                                                ->where('document_type_code', 'IVD')
                                                ->where('number', 'like', date('Ymd').'%')
                                                ->get()
                                                ->count();
                    $cInv = $cInv+1;

                    //Cria doc de inventário
                    $inv = new \App\Models\Document(['company_id' => Auth::user()->company_id,
                                                    'number' => date('Ymd').$cInv,
                                                    'document_type_code' => 'IVD',
                                                    'document_status_id' => 0,
                                                    'inventory_status_id' => 0,
                                                    'inventory_value' => $this->value,
                                                    'billing_type' => $this->billing_type,
                                                    'customer_code' => $this->customer_code,
                                                    'user_id' => Auth::user()->id,
                                                    'emission_date' => \Carbon\Carbon::now(),
                                                    'comments' => $this->parameters,
                                                    'order_fields' => $this->fieldsOrderJson,
                                                    'imported_at' => \Carbon\Carbon::now()
                                                    ]);
                    if(!$inv->save()){
                        $erro = 1;
                        break;
                    }else{
                        $inventoryNumber = $inv->number;
                    }
                }else{
                    $inventoryNumber = $this->documentNumber;
                }

                //Busca prefixo de cliente para gravar o produto com esse valor
                $client = \App\Models\Customer::where('company_id', Auth::user()->company_id)
                                              ->where('code',$this->customer_code)
                                              ->get();
                                              
                $prefixCli = $client[0]->prefix_code ?? '';

                //Desconsidera linha de cabeçalho
                if(trim($desc) == '' && trim($produto) == '') continue;
                
            }
            
            $msgFields = "";

            //Validações de erro na linha
            if(array_key_exists('prd', $order) && trim($produto) == ''){
                $erro = 6;
                $msgFields .= "PRODUTO,";
            }
            if(array_key_exists('ean', $order) && trim($barcode) == ''){
                $erro = 6;
                $msgFields .= "BARCODE,";
            }
            if(array_key_exists('dsc', $order) && trim($desc) == ''){
                $erro = 6;
                $msgFields .= "DESCRIÇÃO,";
            }

            //Se achar alguma linha com descricao e produto em branco, encerra o loop
            if(trim($desc) == '' && trim($produto) == '' && $erro <> 6) break;
            
            //Deposito
            if(trim($deposito) <> '' && $erro == 0){

                //Adiciona os dados do deposito atual para inserir posteriormente
                $arrayInsertDep[] =  ['company_id' => Auth::user()->company_id,
                                        'code' => $deposito,
                                        'department_code' => '1',
                                        'deposit_type_code' => 'REC',
                                        'description' => 'Depósito '.$deposito,
                                        'status' => '1'];
                     
            }

            //Endereço
            if(trim($endere) <> '' && $erro == 0){
                
                    //Adiciona os dados do Endereço atual para inserir posteriormente
                    $arrayInsertEnd[] = ['company_id' => Auth::user()->company_id,
                                         'code' => $endere,
                                         'barcode' => $endere,
                                         'department_code' => '1',
                                         'deposit_code' => $deposito,
                                         'sector_code' => 'REC',
                                         'aisle' => '1',
                                         'column' => 1,
                                         'level' => 1,
                                         'status' => 1,
                                         'location_type_code' => 'BLOCADO',
                                         'location_function_code' => 'ESTOQUE',
                                         'label_type_code' => 'ENDERE',
                                         'stock_type_code' => 3
                                        ];
                                           

            }

            //Se não informar unidade, grava padrão UN
            if(trim($unidade) == ''){
                $unidade = 'UN';
            }


            if($unidade <> 'UN' && $erro == 0){
               //Adiciona os dados do Uom atual para inserir posteriormente, caso seja diferente de UN
                $arrayInsertUom[] = [ 'code' => $unidade, 'description' => $unidade];
            }

            //Produto
            if(trim($produto) <> ''  && $erro == 0){
         
                //Descrição (100 caracteres)
                $desc = (trim($desc) <> '')? substr($desc,0,100) : 'Prd '.$produto;
                
                //Adiciona os dados do produto atual para inserir posteriormente
                $arrayInsertPrd[] = ['company_id' => Auth::user()->company_id, 
                                        'code' => trim($prefixCli.$produto), 
                                        'description' => $desc,
                                        'status' =>  1, 
                                        'product_type_code' => 'PA',
                                        'group_code' => '000',
                                        'customer_code' => trim($this->customer_code), 
                                        'alternative_code' => trim($produto), 
                                        'qty_erp' => $saldo];

                

                //Barcode
                $barcode = (trim($barcode) <> '')? $barcode : $produto;
                if($erro == 0){
                    //Adiciona os dados da embalagem atual para inserir posteriormente
                    $arrayInsertPack[] = ['company_id' => Auth::user()->company_id, 
                                            'product_code' => trim($prefixCli.$produto), 
                                            'barcode' => $barcode,
                                            'level' => 1, 
                                            'uom_code' => "$unidade", 
                                            'prev_qty' => 1, 
                                            'prim_qty' => 1, 
                                            'prev_level' => 1,
                                            'conf_batch' => 0, 
                                            'conf_batch_supplier' => 0, 
                                            'create_label' => 0, 
                                            'print_label' => 1,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')];

                    $arrayInsertBcd[] = ['company_id' => Auth::user()->company_id, 
                                         'product_code' => trim($prefixCli.$produto), 
                                         'barcode' => $barcode,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s') ];

                } 
                
            }

            if(trim($endere) == ''){
                $endere = null;
            }

            //Monta a mensagem de erro para cada linha com problemas
            if(trim($msgFields) <> ''){
                $arrayErrors[] = "Campos não preenchidos na linha $cont: ".substr($msgFields, 0, -1);
            }

            //Insere no banco a cada 4000 registros
            if($cont%4000 == 0 && $erro == 0){
                $return = $this->insertValuesByArray($arrayInsertPrd, $arrayInsertPack, $arrayInsertEnd, $arrayInsertDep, $arrayInsertUom, $arrayInsertBcd);
                if($return <> 0){
                    $erro = $return;
                    break;
                }else{
                    //Limpa os arrays para evitar uma lista muito grande
                    $arrayInsertPrd = array();
                    $arrayInsertPack = array();
                    $arrayInsertEnd = array();
                    $arrayInsertDep = array();
                    $arrayInsertBcd = array();
                }
            }
        }

        if($erro == 0){
            //Insere os registros que sobraram e não foram inseridos dentro do loop
            $return = $this->insertValuesByArray($arrayInsertPrd, $arrayInsertPack, $arrayInsertEnd, $arrayInsertDep, $arrayInsertUom, $arrayInsertBcd);
            if($return <> 0){
                $erro = $return;
            }
        }
        
        //Finaliza
        if($erro == 0){
            DB::commit();
        }else{
            //Campos não preenchidos na linha
            if($erro == 6){
                $msgFields = "ERRO: Campos não preenchidos na linha $cont: ".substr($msgFields, 0, -1);
            }
            DB::rollback();
        }

        return array( $inventoryNumber, $erro, $arrayErrors) ;


    }

    //Faz os inserts em massa tendo como parametros os arrays de informações
    function insertValuesByArray($arrayInsertPrd, $arrayInsertPack, $arrayInsertEnd, $arrayInsertDep, $arrayInsertUom, $arrayInsertBcd){
        $erro = 0;

        if(count($arrayInsertPrd) > 0){
            try { 
                //Insere na tabela products com grupo e tipo default
                $newPrd = DB::table('products')->insertOrIgnore($arrayInsertPrd);
                if(count($arrayInsertPack) > 0){
                    $newPack = DB::table('packings')->insertOrIgnore($arrayInsertPack);
                }
            }catch(\Illuminate\Database\QueryException $ex){ 
                 //Erro ao inserir produtos e/ou embalagens
                dd($ex->getMessage()); 
                $erro = 1;
            }
        }

        if(count($arrayInsertDep) > 0){
            //Insere os depositos
            try { 
                $newDep = DB::table('deposits')->insertOrIgnore(array_unique($arrayInsertDep));
            }catch(\Illuminate\Database\QueryException $ex){ 
                //Erro ao inserir Depositos
                dd($ex->getMessage()); 
                $erro = 2;
            }
        }

        if(count($arrayInsertEnd) > 0){
            //Insere os endereços
            try{
                $newLoc = DB::table('locations')->insertOrIgnore(array_unique($arrayInsertEnd));
            }catch(\Illuminate\Database\QueryException $ex){ 
                //Erro ao inserir locations
                dd($ex->getMessage()); 
                $erro = 3;
            }
        }
        
        if(count($arrayInsertUom) > 0){
            //Insere as unidades
            try{
                $newUom = DB::table('uoms')->insertOrIgnore(array_unique($arrayInsertUom));
            }catch(\Illuminate\Database\QueryException $ex){ 
                //Erro ao inserir Uoms
                dd($ex->getMessage()); 
                $erro = 4;
            }
        }

        if(count($arrayInsertBcd) > 0){
            //Insere os barcodes alternativos do item (referente ao nivel 1)
            try{
                $newBc = DB::table('barcodes')->insertOrIgnore($arrayInsertBcd);
            }catch(\Illuminate\Database\QueryException $ex){ 
                //Erro ao inserir barcodes
                dd($ex->getMessage()); 
                $erro = 5;
            }
        }

        return $erro;
    }
}

