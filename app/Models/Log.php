<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * Class Log
 * @package App\Models
 * @version November 1, 2017, 1:42 pm UTC
 */
class Log extends Model
{
    public $table = 'logs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


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

    
}
