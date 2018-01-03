<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LocationFunction
 * @package App\Models
 * @version December 21, 2017, 1:38 pm UTC
 */
class LocationFunction extends Model
{
    public $table = 'location_functions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
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

    //Retorna todas as funçoes de endereço disponiveis
    public static function getLocationFunctions(){
        return LocationFunction::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                               ->pluck('description_f','code');
    }

    
}
