<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class PalletStatus
 * @package App\Models
 * @version May 23, 2018, 4:16 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string description
 */
class PalletStatus extends Model
{
    public $table = 'pallet_status';
    
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

    

     //Retorna todos os pallet_status disponíveis
     public static function getPalletsStatus(){
        return PalletStatus::selectRaw("id,CONCAT(id,' - ',description) as description_f")
                      ->pluck('description_f','id');
    }


}
