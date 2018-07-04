<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Module
 * @package App\Models
 * @version October 25, 2017, 12:07 pm UTC
 */
class Module extends Model
{
    public $table = 'modules';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'module',
        'submodule',
        'name',
        'enabled',
        'icon',
        'url'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'module' => 'string',
        'submodule' => 'string',
        'enabled' => 'boolean',
        'name' => 'string',
        'icon' => 'string',
        'url' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //Retorna todos os módulos disponíveis
    public static function getModules(){
        return Module::where('enabled', '1')
                     ->whereNotNull('submodule')
                     ->pluck('name','name');
    }

    
}
