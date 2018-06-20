<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class BlockedGroup
 * @package App\Models
 * @version June 20, 2018, 12:06 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property string deposit_code
 * @property string sector_code
 * @property string group_code
 */
class BlockedGroup extends Model
{
    public $table = 'blocked_groups';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'deposit_code',
        'sector_code',
        'group_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'deposit_code' => 'string',
        'sector_code' => 'string',
        'group_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os blocked_groups disponíveis
     public static function getBlockedGroups(){
        return BlockedGroup::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
