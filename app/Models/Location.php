<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Location
 * @package App\Models
 * @version December 21, 2017, 1:47 pm UTC
 */
class Location extends Model
{
    public $table = 'locations';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'department_code',
        'deposit_code',
        'sector_code',
        'code',
        'barcode',
        'aisle',
        'column',
        'level',
        'depth',
        'status',
        'location_type_code',
        'location_function_code',
        'abz_code',
        'label_type_code',
        'stock_type',
        'sequence_arm',
        'sequence_sep',
        'sequence_inv'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'department_code' => 'string',
        'deposit_code' => 'string',
        'sector_code' => 'string',
        'code' => 'string',
        'barcode' => 'string',
        'aisle' => 'string',
        'column' => 'string',
        'location_type_code' => 'string',
        'location_function_code' => 'string',
        'label_type_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
