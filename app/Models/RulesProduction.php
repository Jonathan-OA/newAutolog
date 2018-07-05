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
        $depositos = App\Models\Parameter::getParam("depositos_separacao");
        $itens = App\Models\DocumentItem::getItens($document_id);
        foreach($itens as $item){
            echo $item['item_code'];
            $result = App\Models\Stock::getSaldoDep($depositos, $item['item_code']);
            echo ' ========== ';
        }
        
        print_r($result);exit;

    }

    //Regra que valida o saldo
    public static function prd002($document_id){
        echo 'opa2';

    }
}
