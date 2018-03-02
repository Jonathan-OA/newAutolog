<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class Packing
 * @package App\Models
 * @version March 2, 2018, 1:40 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property smallInteger level
 * @property string product_code
 * @property string uom_code
 * @property string barcode
 * @property decimal prev_qty
 * @property smallInteger prev_level
 * @property string label_type_code
 * @property decimal total_weight
 * @property decimal total_net_weight
 * @property decimal lenght
 * @property decimal width
 * @property decimal depth
 * @property decimal total_m3
 * @property decimal stacking
 * @property string packing_type_code
 * @property decimal print_label
 * @property decimal create_label
 * @property decimal conf_batch
 * @property decimal conf_weight
 * @property decimal conf_serial
 * @property decimal conf_batch_supplier
 * @property decimal conf_due_date
 * @property decimal conf_prod_date
 * @property decimal conf_length
 * @property decimal conf_width
 * @property decimal conf_height
 */
class Packing extends Model
{
    public $table = 'packings';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'level',
        'product_code',
        'uom_code',
        'barcode',
        'prev_qty',
        'prev_level',
        'label_type_code',
        'total_weight',
        'total_net_weight',
        'lenght',
        'width',
        'depth',
        'total_m3',
        'stacking',
        'packing_type_code',
        'print_label',
        'create_label',
        'conf_batch',
        'conf_weight',
        'conf_serial',
        'conf_batch_supplier',
        'conf_due_date',
        'conf_prod_date',
        'conf_length',
        'conf_width',
        'conf_height'
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
        'barcode' => 'string',
        'label_type_code' => 'string',
        'packing_type_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os packings disponíveis
     public static function getPackings(){
        return Packing::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
