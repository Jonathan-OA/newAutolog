<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class BlockedLocation
 * @package App\Models
 * @version July 5, 2018, 4:08 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property string location_code
 * @property string product_code
 */
class BlockedLocation extends Model
{
    public $table = 'blocked_locations';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'location_code',
        'product_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'location_code' => 'string',
        'product_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os blocked_locations disponíveis
     public static function getBlockedLocations(){
        return BlockedLocation::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
