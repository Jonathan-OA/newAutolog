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

    //Parametros de inventário enviados pelo construtor no controller de inventário
    //Customer = Cliente e Value = Valor por Leitura
    public function __construct($parameters, $customer, $value){
        $this->parameters = $parameters;
        $this->customer_code = $customer;
        $this->value = $value;
    }

    

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function array($row, $params = "")
    {   
        $isTxt = false;

        //SE É UM ARRAY, INDICA QUE A IMPORTAÇÃO É VIA EXCEL
        //SE NÃO FOR, TESTA SE É UM ARQUIVO
        if(!is_array($row)){
            $row = explode("\n", $row);
            $isTxt = true;
            //Sem parâmetros informados (Array(separator e order))
            if(empty($params)){
                $erro = 1;
                return $erro;
            }else{
                $separator = $params['separator'];
                $order = $params['order'];
            }
        }

        $totLines = count($row) - 1;
        $cont = 0;
        $erro = 0;
        //echo $this->parameters;exit; 
        //DB::beginTransaction();
        
        foreach($row as $key => $line){
            $cont++;
            
            if(trim($line) == "") break; //Ultima linha vazia
            
            //Se for um txt, quebra cada linha pelo caractere separador
            if($isTxt){
                $line = explode($separator, $line);
            }

           
            
            $endere = ($isTxt) ? ((array_key_exists('end', $order)) ? $line[$order['end']] : '') : $line[0];
            $deposito = ($isTxt) ? ((array_key_exists('dep', $order)) ? $line[$order['dep']] : '') : $line[1];
            $produto = ($isTxt) ? ((array_key_exists('prd', $order)) ? $line[$order['prd']] : '') : $line[2];
            $desc = ($isTxt) ? ((array_key_exists('dsc', $order)) ? $line[$order['dsc']] : '') : $line[3];
            $barcode = ($isTxt) ? ((array_key_exists('ean', $order)) ? $line[$order['ean']] : '') : $line[4];
            $saldo = ($isTxt) ? ((array_key_exists('qde', $order)) ? $line[$order['qde']] : '') : $line[5];
            $unidade = ($isTxt) ? ((array_key_exists('uni', $order)) ? $line[$order['uni']] : '') : $line[6];

            
            

            //Primeira linha
            if($cont == 1) {
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
                                                 'customer_code' => $this->customer_code,
                                                 'user_id' => Auth::user()->id,
                                                 'emission_date' => \Carbon\Carbon::now(),
                                                 'comments' => $this->parameters
                                                ]);
                if(!$inv->save()){
                    $erro = 1;
                    break;
                }

                //Desconsidera linha de cabeçalho
                if(trim($desc) == '' && trim($produto) == '') continue;
                
            }

            //Se achar alguma linha com descricao e produto em branco, encerra o loop
            if(trim($desc) == '' && trim($produto) == '') break;
            
            //Deposito
            //Se não informar, grava padrão 99
            if(trim($deposito) == ''){
                $deposito = '99';
            }
            if(trim($deposito) <> ''){
                //Valida se existe
                $cDeposit = \App\Models\Deposit::where('company_id', Auth::user()->company_id)
                                               ->where('code', trim($deposito))
                                               ->get()
                                               ->count();
                if($cDeposit == 0){
                    //Insere na tabela
                    $newDep = new \App\Models\Deposit(['company_id' => Auth::user()->company_id,
                                                      'code' => $deposito,
                                                      'department_code' => '1',
                                                      'deposit_type_code' => 'REC',
                                                      'description' => 'Depósito '.$deposito,
                                                      'status' => '1'
                                                      ]);
                    if(!$newDep->save()){
                        $erro = 1;
                    }
                }       
                
            }

            //Endereço
            //Se não informar, grava padrão DEF
            if(trim($endere) == ''){
                $endere = 'DEF';
            }
            if(trim($endere) <> '' && $erro == 0){
                //Valida se existe
                $cLocation = \App\Models\Location::where('company_id', Auth::user()->company_id)
                                               ->where('code', trim($endere))
                                               ->get()
                                               ->count();
                if($cLocation == 0){
                    //Insere na tabela
                    $newLoc = new \App\Models\Location(['company_id' => Auth::user()->company_id,
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
                                                        ]);

                    if(!$newLoc->save()){
                        $erro = 1;
                    }
                }                               

            }
            //Se não informar unidade, grava padrão UN
            if(trim($unidade) == ''){
                $unidade = 'UN';
            }

            //Unidade
            $cUnid = \App\Models\Uom::where('code', trim($unidade))
                                    ->get()
                                    ->count();
            if($cUnid == 0){
                //Insere UOM
                $newUom = new \App\Models\Uom([ 'code' => $unidade,
                                                'description' => $unidade]);

                if(!$newUom->save()){
                    $erro = 1;
                }
            }

            //Produto
            if(trim($produto) <> ''  && $erro == 0){

                $cProd = \App\Models\Product::where('company_id', Auth::user()->company_id)
                                            ->where('code', trim($produto))
                                            ->get()
                                            ->count();
                if($cProd == 0){
                    //Descrição (100 caracteres)
                    $desc = (trim($desc) <> '')? substr(utf8_encode($desc),0,100) : 'Prd '.$produto;

                    //Insere da products com grupo e tipo default
                    $newPrd = new \App\Models\Product([ 'company_id' => Auth::user()->company_id,
                                                        'code' => $produto,
                                                        'description' => $desc,
                                                        'status' => 1,
                                                        'product_type_code' => 'PA',
                                                        'group_code' => '000',
                                                        ]);

                    if(!$newPrd->save()){
                        $erro = 1;
                    }


                    //Barcode
                    $barcode = (trim($barcode) <> '')? $barcode : $produto;
                    if($erro == 0){
                        $cPack = \App\Models\Packing::where('company_id', Auth::user()->company_id)
                                                     ->where('product_code', trim($produto))
                                                     ->where('barcode', trim($barcode))
                                                     ->get()
                                                     ->count();
                        if($cPack == 0){
                            //Insere embalagem
                            $newPack = new \App\Models\Packing([ 'company_id' => Auth::user()->company_id,
                                                                 'product_code' => $produto,
                                                                 'barcode' => $barcode,
                                                                 'level' => '1',
                                                                 'uom_code' => 'UN',
                                                                 'prev_qty' => 1 ,
                                                                 'prim_qty' => 1,
                                                                 'prev_level' => 1,
                                                                 'conf_batch' => 0,
                                                                 'conf_batch_supplier' => 0,
                                                                 'create_label' => 1,
                                                                 'print_label' => 1
                                                                ]);

                            if(!$newPack->save()){
                                $erro = 1;
                            }

                        }
                        
                    } 
                }
            }

            if($erro == 0){
                //Grava na inventory_itens
                $invItem = new \App\Models\InventoryItem(['company_id' => Auth::user()->company_id,
                                                          'document_id' => $inv->id,
                                                          'product_code' => $produto,
                                                          'location_code' => $endere,
                                                          'qty_wms' => $saldo,
                                                          'uom_code' => $unidade,
                                                          'prim_uom_code' => $unidade,
                                                          'inventory_status_id' => 0
                                                        ]);
                if(!$invItem->save()){
                    $erro = 1;
                    break;
                }
            }else{
                break;
            }
            
        }

        if($erro == 0){
            //DB::commit();
        }else{
            //DB::rollback();
            echo 'erroooo';
        }

        return $erro;


    }
}
