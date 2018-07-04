<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class LiberationRule
 * @package App\Models
 * @version July 4, 2018, 1:43 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string code
 * @property string module_name
 * @property boolean enabled
 */
class LiberationRule extends Model
{
    public $table = 'liberation_rules';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'code',
        'module_name',
        'enabled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'module_name' => 'string',
        'enabled' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os liberation_rules disponíveis
     public static function getLiberationRules(){
        return LiberationRule::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
