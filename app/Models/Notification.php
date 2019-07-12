<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class Notification
 * @package App\Models
 * @version July 10, 2019, 5:34 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection blockedOperations
 * @property \Illuminate\Database\Eloquent\Collection deposits
 * @property \Illuminate\Database\Eloquent\Collection documentTypes
 * @property \Illuminate\Database\Eloquent\Collection groups
 * @property \Illuminate\Database\Eloquent\Collection labelLayouts
 * @property \Illuminate\Database\Eloquent\Collection parameters
 * @property \Illuminate\Database\Eloquent\Collection userPermissions
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection vehicles
 * @property \Illuminate\Database\Eloquent\Collection volumes
 * @property bigInteger user_id
 * @property string message
 * @property boolean visualized
 */
class Notification extends Model
{
    public $table = 'notifications';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'user_id',
        'message',
        'visualized'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'message' => 'string',
        'visualized' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os notifications disponíveis
     public static function getNotifications(){
        return Notification::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}