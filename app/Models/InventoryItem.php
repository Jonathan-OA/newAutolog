<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class InventoryItem
 * @package App\Models
 * @version January 29, 2019, 2:58 pm -02
 *
 * @property \App\Models\InventoryStatus inventoryStatus
 * @property \Illuminate\Database\Eloquent\Collection blockedOperations
 * @property \Illuminate\Database\Eloquent\Collection deposits
 * @property \Illuminate\Database\Eloquent\Collection layouts
 * @property \Illuminate\Database\Eloquent\Collection logs
 * @property \Illuminate\Database\Eloquent\Collection parameters
 * @property \Illuminate\Database\Eloquent\Collection userPermissions
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection vehicles
 * @property \Illuminate\Database\Eloquent\Collection volumes
 * @property integer company_id
 * @property bigInteger document_id
 * @property string product_code
 * @property bigInteger pallet_id
 * @property bigInteger label_id
 * @property string location_code
 * @property decimal qty_wms
 * @property smallInteger inventory_status_id
 * @property decimal qty_1count
 * @property string user_1count
 * @property string|\Carbon\Carbon date_1count
 * @property decimal qty_2count
 * @property string user_2count
 * @property string|\Carbon\Carbon date_2count
 * @property decimal qty_3count
 * @property string user_3count
 * @property string|\Carbon\Carbon date_3count
 * @property decimal qty_4count
 * @property string user_4count
 * @property string|\Carbon\Carbon date_4count
 */
class InventoryItem extends Model
{
    public $table = 'inventory_items';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'document_id',
        'product_code',
        'pallet_id',
        'label_id',
        'location_code',
        'qty_wms',
        'inventory_status_id',
        'qty_1count',
        'user_1count',
        'date_1count',
        'qty_2count',
        'user_2count',
        'date_2count',
        'qty_3count',
        'user_3count',
        'date_3count',
        'qty_4count',
        'user_4count',
        'date_4count'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'product_code' => 'string',
        'location_code' => 'string',
        'user_1count' => 'string',
        'user_2count' => 'string',
        'user_3count' => 'string',
        'user_4count' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function inventoryStatus()
    {
        return $this->belongsTo(\App\Models\InventoryStatus::class);
    }

     //Retorna todos os inventory_items disponíveis
     public static function getInventoryItems(){
        return InventoryItem::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
