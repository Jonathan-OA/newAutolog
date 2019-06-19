<?php

namespace App\Models;

use Eloquent as Model;
use Auth;
use DB;


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
        'id',
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

    /**
     * Função que retorna informações para impressão (em formato de array)
     *
     * @param document_id
     * @var array
     */
    public static function getInfosForPrint($document_id){

        return DocumentItem::select('document_items.id','document_items.company_id','document_items.document_id','document_items.product_code',
                                    'document_items.qty','document_items.uom_code as prim_uom_code','document_status_id','document_items.batch',
                                    'document_items.batch_supplier','document_items.serial_number','qty_conf','qty_ship','qty_reject','invoice','invoice_serial_number',
                                    'sequence_item','umvcad_id','location_code','source','document_items.obs1',
                                    'document_items.obs2','document_items.obs3','document_items.obs4','document_items.obs5',
                                    'document_items.created_at', 'document_status.description', DB::raw("COUNT(distinct labels.id) as total_labels"),
                                    DB::raw("(SELECT pack_imp.UOM_CODE FROM packings pack_imp 
                                              WHERE pack_imp.company_id = products.company_id and
                                                    pack_imp.product_code = products.code and
                                                    pack_imp.print_label= 1 LIMIT 1) as uom_print"))
                            ->join('document_status','document_status.id','document_items.document_status_id')
                            ->join('products', function ($join) {
                                $join->on('products.code','document_items.product_code')
                                    ->whereColumn('products.company_id','document_items.company_id');
                            })
                            ->join('packings', function ($join) {
                                $join->on('packings.product_code','document_items.product_code')
                                    ->whereColumn('packings.company_id','document_items.company_id')
                                    ->whereColumn('packings.uom_code','document_items.uom_code');
                            })
                            ->leftJoin('labels', function ($join) {
                                $join->on('labels.document_id','document_items.document_id')
                                    ->whereColumn('labels.company_id','document_items.company_id')
                                    ->whereColumn('labels.document_item_id','document_items.id')
                                    ->where('labels.label_status_id','<>', 9);
                            })
                            ->where('document_items.company_id', Auth::user()->company_id)
                            ->where('document_items.document_id', $document_id)
                            ->groupBy('document_items.id','document_items.company_id','document_items.document_id','document_items.product_code',
                                      'document_items.qty','document_items.uom_code','document_status_id','document_items.batch','document_items.batch_supplier',
                                      'document_items.serial_number','qty_conf','qty_ship','qty_reject','invoice','invoice_serial_number',
                                      'sequence_item','umvcad_id','location_code','source','document_items.obs1',
                                      'document_items.obs2','document_items.obs3','document_items.obs4','document_items.obs5',
                                      'document_items.created_at', 'document_status.description')
                            ->get()
                            ->toArray();

    }

     //Retorna todos os itens disponíveis em um documento desconsiderando o status do parâmetro
     public static function getItens($document_id, $statusDsc = ''){
        
        return DocumentItem::select('document_items.id','company_id','document_id','product_code','qty','uom_code',
                                    'document_status_id','batch','batch_supplier','serial_number','qty_conf','qty_ship',
                                    'qty_reject','invoice','invoice_serial_number','sequence_item','umvcad_id','location_code',
                                    'source','obs1','obs2','obs3','obs4','obs5','document_items.created_at', 'description')
                            ->join('document_status','document_status.id','document_items.document_status_id')
                            ->where('company_id', Auth::user()->company_id)
                            ->where('document_id', $document_id)
                            ->where(function ($query) {
                                if(!empty($statusDsc)){
                                    $query->where('document_status.id', '<>' ,$statusDsc);
                                }
                            })
                            ->get()
                            ->toArray();
    }


}
