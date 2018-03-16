<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class Courier
 * @package App\Models
 * @version March 13, 2018, 3:24 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string code
 * @property integer company_id
 * @property string name
 * @property string trading_name
 * @property string cnpj
 * @property string state_registration
 * @property string address
 * @property smallInteger number
 * @property string neighbourhood
 * @property string city
 * @property string state
 * @property string country
 * @property string zip_code
 * @property string phone1
 * @property string phone2
 * @property smallInteger status
 * @property string obs1
 * @property string obs2
 * @property string obs3
 */
class Courier extends Model
{
    public $table = 'couriers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
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
        'status',
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

    

     //Retorna todos os couriers disponíveis
     public static function getCouriers(){
        return Courier::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
