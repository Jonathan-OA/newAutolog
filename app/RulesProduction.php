<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class RulesProduction
 * @package App\Models
 * @version July, 2018, 10:57 am -03
 *
 * Classe que contem todas as regras de liberação para documentos de produção
 * 
 */

class RulesProduction extends Model
{

    //Regra que valida o saldo
    public static function prd001($document_id){
        echo 'opa';

    }

    //Regra que valida o saldo
    public static function prd002($document_id){
        echo 'opa2';

    }
}
