<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class DocumentItem
 * @package App\Models
 * @version July 13, 2018, 5:41 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property bigInteger document_id
 * @property string product_code
 * @property decimal qty
 * @property string uom_code
 * @property smallInteger document_status_id
 * @property string batch
 * @property string batch_supplier
 * @property string serial_number
 * @property decimal qty_conf
 * @property decimal qty_ship
 * @property decimal qty_reject
 * @property string invoice
 * @property string invoice_serial_number
 * @property bigInteger sequence_item
 * @property bigInteger umvcad_id
 * @property string location_code
 * @property string source
 * @property string obs1
 * @property string obs2
 * @property string obs3
 * @property string obs4
 * @property string obs5
 */
class DocumentItem extends Model
{
    public $table = 'document_items';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'document_id',
        'product_code',
        'qty',
        'uom_code',
        'document_status_id',
        'batch',
        'batch_supplier',
        'serial_number',
        'qty_conf',
        'qty_ship',
        'qty_reject',
        'invoice',
        'invoice_serial_number',
        'sequence_item',
        'umvcad_id',
        'location_code',
        'source',
        'obs1',
        'obs2',
        'obs3',
        'obs4',
        'obs5'
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
        'batch' => 'string',
        'batch_supplier' => 'string',
        'serial_number' => 'string',
        'invoice' => 'string',
        'invoice_serial_number' => 'string',
        'location_code' => 'string',
        'source' => 'string',
        'obs1' => 'string',
        'obs2' => 'string',
        'obs3' => 'string',
        'obs4' => 'string',
        'obs5' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os document_items disponíveis
     public static function getDocumentItems(){
        return DocumentItem::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
