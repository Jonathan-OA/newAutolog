<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Moviment
 * @package App\Models
 * @version March 1, 2018, 7:25 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string code
 * @property string description
 */
class Moviment extends Model
{

    public $table = 'moviments';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'code',
        'description',
        'document_type_wave'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * Função que retorna a qual classe e modulo pertence o movimento indicado
     * Parâmetros: Código do Movimento
     * @var array
     */

    public static function getClass($moviment_code){

        $class = '';

        //Switch para definir qual classe de liberação será utilizada para manipular documentos desse movimento
        switch($moviment_code){
                
            //Recebimento
            case '010':
                $class = 'App\Models\RulesReceipt';
                $urlRet = 'receipt'; //Rota para retornar após a ação
                break;

            //Transferência
            case '020':
                $class = 'App\Models\RulesTransf';
                $urlRet = 'transference'; //Rota para retornar após a ação
                break;

            //Produção
            case '030':
                $class = 'App\Models\RulesProduction';
                $urlRet = 'production'; //Rota para retornar após a ação
                break;

            //Separação
            case '070':
                $class = 'App\Models\RulesSeparation';
                $urlRet = 'separation'; //Rota para retornar após a ação
                break;

        }

        if(trim($class) == ''){
            return false;
        }else{
            return array('class' => $class,'urlRet' => $urlRet);
        }

    }

    /**
     * Função que retorna o tipo de documento a ser gerado em liberação por onda
     * Se não estiver preenchido, apenas será gerado o número da onda no campo wave(documents)
     * Parâmetros: Código do Movimento
     * @var array
     */

    public static function getDocWave($moviment_code){
        $docWave = Moviment::select('document_type_wave')
                           ->where('code', $moviment_code)
                           ->get();

        return $docWave;
    }



    //Retorna todos os $TABLE_NAME$ disponíveis
    public static function getMoviments(){
        return Moviment::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                       ->pluck('description_f','code');
    }
}
