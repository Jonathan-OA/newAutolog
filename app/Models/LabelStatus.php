<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class LabelStatus
 * @package App\Models
 * @version June 7, 2018, 5:47 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string description
 */
class LabelStatus extends Model
{
    public $table = 'label_status';
    
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

    

     //Retorna todos os label_status disponíveis
     public static function getLabelStatus(){
        return LabelStatus::selectRaw("id,CONCAT(id,' - ',description) as description_f")
                      ->pluck('description_f','id');
    }


}
