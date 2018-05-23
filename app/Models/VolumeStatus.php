<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class VolumeStatus
 * @package App\Models
 * @version May 23, 2018, 4:09 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string description
 */
class VolumeStatus extends Model
{
    public $table = 'volume_status';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'id','description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os volume_status disponíveis
     public static function getVolumesStatus(){
        return VolumeStatus::selectRaw("id,CONCAT(id,' - ',description) as description_f")
                      ->pluck('description_f','id');
    }


}
