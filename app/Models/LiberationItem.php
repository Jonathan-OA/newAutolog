<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class LiberationItem
 * @package App\Models
 * @version July 5, 2018, 3:25 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property bigInteger document_id
 * @property bigInteger document_item_id
 * @property string product_code
 * @property bigInteger pallet_id
 * @property bigInteger label_id
 * @property decimal qty
 * @property smallInteger liberation_status_id
 * @property string orig_location_code
 * @property string dest_location_code
 * @property bigInteger task_id
 */
class LiberationItem extends Model
{
    public $table = 'liberation_items';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'document_id',
        'document_item_id',
        'product_code',
        'pallet_id',
        'label_id',
        'qty',
        'liberation_status_id',
        'orig_location_code',
        'dest_location_code',
        'task_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'product_code' => 'string',
        'orig_location_code' => 'string',
        'dest_location_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os liberation_items disponíveis
     public static function getLiberationItems(){
        return LiberationItem::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
