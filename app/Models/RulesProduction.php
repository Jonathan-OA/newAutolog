<?php

namespace App\Models;
use App;
use DB;

use Illuminate\Database\Eloquent\Model;

class RulesProduction extends Model
{
    
    // Regra Base - Valida se o documento possui itens
    public static function prd000($document_id){
        //Retorna itens que não estejam cancelados para o documento
        $itens = App\Models\DocumentItem::getItens($document_id, 9);
        if(count($itens) == 0){
            $ret['erro'] = 1;
            $ret['msg'] = 'Sem itens para liberar';
        }else{
            $ret['erro'] = 0;
            $ret['msg'] = '';
        }
        return $ret;
    }

    //Regra que realiza as reservas
    public static function prd001($document_id){
        
        $erro = 0;
        $itensSemSaldo = '';

        $depositos = App\Models\Parameter::getParam("depositos_producao",'1');
        $tarefa = App\Models\Parameter::getParam("tarefa_producao",'991');

        $itens = App\Models\DocumentItem::getItens($document_id, 9);
        //Loop em todos os itens do documento
        foreach($itens as $item){
            $qdeItem = $item['qty'];
            $restante = $qdeItem;
            //Busca saldo disponível nos depositos para esse produto
            $saldos = App\Models\Stock::getStockDep($depositos, $item['product_code']);

            foreach($saldos as $saldo){
                if($saldo->qty <= $restante){
                    $qdeSaldo = $saldo->qty;
                    $restante -= $qdeSaldo;
                }else{
                    $qdeSaldo = $restante;
                    $restante = 0;
                }
                //Insere informações na tabela de liberações
                $ins = new App\Models\LiberationItem($item,$saldo->pallet_id,$saldo->label_id,$qdeSaldo,$saldo->location_code,'DEST');
                //Insere reserva do item
                $input['product_code'] = $saldo->product_code;
                $input['document_id'] = $item['id'];
                $input['document_item_id'] = $document_id;
                $input['location_code'] = $saldo->location_code;
                $input['uom_code'] = $saldo->uom_code;
                $input['prev_uom_code'] = $saldo->uom_code;
                $input['label_id'] = $saldo->label_id;
                $input['pallet_id'] = $saldo->pallet_id;
                $input['prev_qty'] = $qdeSaldo;
                $input['qty'] = $qdeSaldo;
                $input['operation_code'] = '991';

                $storeserck = App\Models\Stock::atuSaldo($input,'RESERVA');

                //Se chegou na quantidade necessária do item, sai do loop de saldos para esse produto
                if($restante <= 0){
                    break;
                }
                
            }
            //Buscou todos os saldos do produto e não bateu a quantidade =  erro
            if($restante > 0){
                $erro = 1;
                $itensSemSaldo.= ' '.$item['product_code'].' ('.$restante.')';
            }
            
        }
        
        if($erro == 0){
            $ret['erro'] = 0;
            $ret['msg'] = '';
        }else{
            $ret['erro'] = 1;
            $ret['msg'] = 'Os seguintes itens não possuem saldo: '.$itensSemSaldo;
        }

        return $ret;

    }

    //Regra que cria tarefa de produção e atualiza status
    public static function prd002($document_id){
        
        $doc = App\Models\Document::find($document_id);
        $doc->document_status_id = 1;
        $doc->save();

    }

    //Regra que cria tarefa de produção e atualiza status
    public static function prd003($document_id){
        
        $doc = App\Models\Document::find($document_id);
        $doc->document_status_id = 1;
        $doc->save();

    }

    //Regra que cria tarefa de produção e atualiza status
    public static function prd004($document_id){
        
        $doc = App\Models\Document::find($document_id);
        $doc->document_status_id = 1;
        $doc->save();

    }

    //Regra que cria tarefa de produção e atualiza status
    public static function prd005($document_id){
        
        $doc = App\Models\Document::find($document_id);
        $doc->document_status_id = 1;
        $doc->save();

    }

    //Regra que cria tarefa de produção e atualiza status
    public static function prd006($document_id){
        
        $doc = App\Models\Document::find($document_id);
        $doc->document_status_id = 1;
        $doc->save();

    }

    //Regra que cria tarefa de produção e atualiza status
    public static function prd007($document_id){
        
        $doc = App\Models\Document::find($document_id);
        $doc->document_status_id = 1;
        $doc->save();

    }
}
