<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class Vehicle
 * @package App\Models
 * @version March 13, 2018, 3:24 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property integer courier_id
 * @property integer vehicle_type_id
 * @property string number_plate
 */
class Vehicle extends Model
{
    public $table = 'vehicles';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
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

    

     //Retorna todos os vehicles disponíveis
     public static function getVehicles(){
        return Vehicle::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
