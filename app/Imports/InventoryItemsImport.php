<?php

namespace App\Imports;
use Auth;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToArray;

class InventoryItemsImport implements ToArray
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function array(array $row)
    {   
        $totLines = count($row) - 1;
        $cont = 0;
        
        foreach($row as $key => $line){
            $cont++;
            $erro = 0;
            
            $endere = $line[0];
            $deposito = $line[1];
            $produto = $line[2];
            $desc = $line[3];
            $barcode = $line[4];
            $saldo = $line[5];
            $unidade = $line[6];

            if($cont == 1) {
                //Cria doc de inventário
                $inv = new \App\Models\Document(['company_id' => Auth::user()->company_id,
                                                 'number' => date('Ymdh'),
                                                 'document_type_code' => 'IVD',
                                                 'document_status_id' => 0,
                                                 'inventory_status_id' => 0,
                                                 'user_id' => Auth::user()->id
                                                ]);
                if(!$inv->save()){
                    $erro = 1;
                    break;
                }

                //Desconsidera linha de cabeçalho
                continue; 
            }

            //Deposito
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
            if(trim($endere) <> ''){
                //Valida se existe
                $cLocation = \App\Models\Location::where('company_id', Auth::user()->company_id)
                                               ->where('code', trim($endere))
                                               ->get()
                                               ->count();
                if($cLocation == 0 && $erro == 0){
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
                                                        'stock_type_code' => 0
                                                        ]);

                    if(!$newLoc->save()){
                        $erro = 1;
                    }
                }                               

            }

            //Produto
            if(trim($produto) <> ''){

                $cProd = \App\Models\Product::where('company_id', Auth::user()->company_id)
                                            ->where('code', trim($produto))
                                            ->get()
                                            ->count();
                if($cProd == 0){
                    //Descrição
                    $desc = (trim($desc) <> '')? $desc : 'Prd '.$produto;

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
                        $cPack = \App\Models\Packings::where('company_id', Auth::user()->company_id)
                                                     ->where('product_code', trim($produto))
                                                     ->where('barcode', trim($barcode))
                                                     ->get()
                                                     ->count();
                        if($cPack == 0){
                            //Insere embalagem
                            $newPack = new \App\Models\Product([ 'company_id' => Auth::user()->company_id,
                                                                 'product_code' => $produto,
                                                                 'barcode' => $barcode,
                                                                 'level' => '1',
                                                                 'uom_code' => 'UN',
                                                                 'prev_qty' => 1 ,
                                                                 'prim_qty' => 1,
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
                                                          'inventory_status_id' => 0
                                                            ]);
                if(!$invItem->save()){
                    $erro = 1;
                    break;
                }
            }



            $cont++;
        }
        
    }
}
