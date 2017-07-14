<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Operations
 * @package App\Models
 * @version July 14, 2017, 2:32 pm UTC
 */
class Operations extends Model
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

    
}
