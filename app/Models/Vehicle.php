<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Vehicle
 * @package App\Models
 * @version April 10, 2017, 12:33 pm UTC
 */
class Vehicle extends Model
{
  

    public $table = 'vehicles';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'courier_id',
        'vehicle_type_id',
        'number_plate'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'courier_id' => 'integer',
        'vehicle_type_id' => 'integer',
        'number_plate' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
