<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class Log
 * @package App\Models
 * @version July 16, 2018, 12:05 am -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property string description
 * @property integer user_id
 * @property string operation_code
 */
class Log extends Model
{
    public $table = 'logs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'description',
        'user_id',
        'operation_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'description' => 'string',
        'user_id' => 'integer',
        'operation_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
    /**
     * Função que insere o log de uma operação no sistema
     *
     * @var array
     */
    public static function wlog($oper, $desc){
        //Só grava o log se a opção WRITES_LOG da Operação estiver habilitada
        if(Operation::where('code', $oper)->where('writes_log',1)->count() == 1){
            Log::create(['company_id' => Auth::user()->company_id,
                        'user_id' => Auth::id(),
                        'description' => $desc,
                        'operation_code' => $oper]);
        }

    }
    
     //Retorna todos os logs disponíveis
     public static function getLogs(){
        return Log::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
