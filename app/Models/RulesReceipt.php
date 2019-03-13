<?php

namespace App\Models;
use App;
use DB;

use Illuminate\Database\Eloquent\Model;

class RulesReceipt extends Model
{
    
    // Regra Base - Valida se o documento possui itens
    public static function rec000($document_id){
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

    
}
