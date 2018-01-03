<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LocationType
 * @package App\Models
 * @version December 21, 2017, 1:42 pm UTC
 */
class LocationType extends Model
{
    public $table = 'location_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'description',
        'capacity_kg',
        'capacity_m3',
        'capacity_qty',
        'length',
        'width',
        'height'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
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

     //Retorna todas os tipos de endereço disponiveis
     public static function getLocationTypes(){
        return LocationType::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                           ->pluck('description_f','code');
    }

    
}
