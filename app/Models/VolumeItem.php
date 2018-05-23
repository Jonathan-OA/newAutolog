<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class VolumeItem
 * @package App\Models
 * @version March 28, 2018, 4:06 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property bigInteger volume_id
 * @property string product_code
 * @property decimal qty
 * @property string uom_code
 * @property decimal prim_qty
 * @property string prim_uom_code
 * @property bigInteger label_id
 * @property bigInteger activity_id
 * @property smallInteger status
 * @property smallInteger turn
 */
class VolumeItem extends Model
{
    public $table = 'volume_items';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'volume_id',
        'product_code',
        'qty',
        'uom_code',
        'prim_qty',
        'prim_uom_code',
        'label_id',
        'activity_id',
        'status',
        'turn'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'product_code' => 'string',
        'uom_code' => 'string',
        'prim_uom_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os volume_items disponíveis
     public static function getVolumeItems(){
        return VolumeItem::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
