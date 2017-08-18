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
        
    ];

    //Retorna todas as operações disponíveis no módulo
    public static function getOperations($module = ' '){
        return Operation::where('module', $module)
                        ->where('enabled', '1')
                        ->where('module', '<>', ' ')
                        ->pluck('name','name');
    }

    
}
