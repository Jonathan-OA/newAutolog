<?php

namespace App\Models;
use App;
use DB;

use Illuminate\Database\Eloquent\Model;

class RulesProduction extends Model
{
    
    //Regra que valida o saldo
    public static function prd001($document_id){
        DB::beginTransaction();
        DB::commit();
        $depositos = App\Models\Parameter::getParam("depositos_producao");
        $itens = App\Models\DocumentItem::getItens($document_id);

        foreach($itens as $item){
            $qdeItem = $item['qty'];
            $restante = $qdeItem;
            //Loop até bater a quantidade solicitada do item
            $saldos = App\Models\Stock::getSaldoDep($depositos, $item['item_code']);
            foreach($saldos as $saldo){
                print_r($saldo);
                //$ins = new App\Models\LiberationItem($item,NULL,NULL,5,'ORG','DEST');


                
            }
            
            
            echo ' ========== ';
        }
        
        exit;

    }

    //Regra que valida o saldo
    public static function prd002($document_id){
        echo 'opa2';

    }
}
