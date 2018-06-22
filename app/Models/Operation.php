<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Operation
 * @package App\Models
 * @version August 3, 2017, 7:23 pm UTC
 */
class Operation extends Model
{
    public $table = 'operations';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'type',
        'module',
        'level',
        'action',
        'description',
        'local',
        'writes_log',
        'enabled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type' => 'string',
        'module' => 'string',
        'level' => 'integer',
        'action' => 'string',
        'description' => 'string',
        'local' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required|string|max:30',
        'type' => 'required|alpha|max:7',
        'description' => 'required|string|max:50',
        'module' => 'required|string|max:20',
        'level'  => 'digits:1', 
        'action' => 'required|string|max:20',
        'local'  => 'required|string|max:20',
    ];

    /**
     * Retorna todas as operações disponíveis no módulo
     *
     * Função utilizada para preencher os inputs do tipo SELECT
     */
    public static function getOperations($tipo = '', $module = ' '){
        return Operation::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                        ->where('enabled', '1')
                        ->where('module', '<>', ' ')
                        ->where(function ($query) {
                            if(!empty($tipo)){
                                $query->where('type',$tipo);
                            }
                        })
                        ->pluck('description_f','code');
    }

    
}
