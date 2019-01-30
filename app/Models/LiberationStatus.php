<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class LiberationStatus
 * @package App\Models
 * @version January 30, 2019, 11:16 am -02
 *
 * @property \Illuminate\Database\Eloquent\Collection blockedOperations
 * @property \Illuminate\Database\Eloquent\Collection deposits
 * @property \Illuminate\Database\Eloquent\Collection layouts
 * @property \Illuminate\Database\Eloquent\Collection LiberationItem
 * @property \Illuminate\Database\Eloquent\Collection logs
 * @property \Illuminate\Database\Eloquent\Collection parameters
 * @property \Illuminate\Database\Eloquent\Collection userPermissions
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection vehicles
 * @property \Illuminate\Database\Eloquent\Collection volumes
 * @property string description
 */
class LiberationStatus extends Model
{
    public $table = 'liberation_status';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function liberationItems()
    {
        return $this->hasMany(\App\Models\LiberationItem::class);
    }

     //Retorna todos os liberation_status disponíveis
     public static function getLiberationStatus(){
        return LiberationStatus::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->pluck('description_f','code');
    }


}
