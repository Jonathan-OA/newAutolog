<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class TaskStatus
 * @package App\Models
 * @version August 22, 2018, 3:08 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection blockedOperations
 * @property \Illuminate\Database\Eloquent\Collection deposits
 * @property \Illuminate\Database\Eloquent\Collection layouts
 * @property \Illuminate\Database\Eloquent\Collection logs
 * @property \Illuminate\Database\Eloquent\Collection parameters
 * @property \Illuminate\Database\Eloquent\Collection userPermissions
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection vehicles
 * @property \Illuminate\Database\Eloquent\Collection volumes
 * @property string description
 */
class TaskStatus extends Model
{
    public $table = 'task_status';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'id',
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

    

     //Retorna todos os task_status disponíveis
     public static function getTaskStatus(){
        return TaskStatus::selectRaw("id,CONCAT(id,' - ',description) as description_f")
                      ->pluck('description_f','id');
    }


}
