<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Supplier
 * @package App\Models
 * @version July 6, 2017, 12:32 pm UTC
 */
class Supplier extends Model
{
    public $table = 'suppliers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'company_id',
        'name',
        'trading_name',
        'cnpj',
        'state_registration',
        'address',
        'number',
        'neighbourhood',
        'city',
        'state',
        'country',
        'zip_code',
        'phone1',
        'phone2',
        'active',
        'obs1',
        'obs2',
        'obs3'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'company_id' => 'integer',
        'name' => 'string',
        'trading_name' => 'string',
        'cnpj' => 'string',
        'state_registration' => 'string',
        'address' => 'string',
        'neighbourhood' => 'string',
        'city' => 'string',
        'state' => 'string',
        'country' => 'string',
        'zip_code' => 'string',
        'phone1' => 'string',
        'phone2' => 'string',
        'obs1' => 'string',
        'obs2' => 'string',
        'obs3' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
