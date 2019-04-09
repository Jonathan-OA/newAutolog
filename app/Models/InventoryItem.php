<?php

namespace App\Models;

use Eloquent as Model;
use Auth;
use DB;


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
        'uom_code',
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
     * Retorna todos os itens disponíveis em um documento desconsiderando o status do parâmetro
     *
     * @var array
     */
     
     public static function getItens($document_id, $statusDsc = ''){
        
        return InventoryItem::select(DB::raw("MIN(inventory_items.id) as id "),'inventory_items.company_id',
                                    'document_id','inventory_items.product_code','location_code',DB::raw("SUM(qty_wms) as qty"),
                                    'inventory_items.created_at', 'description', 'deposit_code', 'inventory_status_id', 'uom_code')
                            ->join('inventory_status','inventory_status.id','inventory_items.inventory_status_id')
                            ->join('locations', function($join){
                                $join->on('locations.code','inventory_items.location_code')
                                     ->whereColumn('locations.company_id','inventory_items.company_id');
                            })
                            ->where('inventory_items.company_id', Auth::user()->company_id)
                            ->where('document_id', $document_id)
                            ->where(function ($query) {
                                if(!empty($statusDsc)){
                                    $query->where('inventory_status_id.id', '<>' ,$statusDsc);
                                }
                            })
                            ->groupBy('inventory_items.company_id', 
                                      'document_id',
                                      'inventory_items.product_code',
                                      'location_code',
                                      'inventory_items.created_at',
                                      'description',
                                      'deposit_code',
                                      'inventory_status_id',
                                      'uom_code')
                            ->get()
                            ->toArray();
    }

    /**
     * Retorna as leituras realizadas no inventário
     *
     * @var document_id e @var count 
     */
     
    public static function getAppointments($document_id, $count = ''){
        
        return InventoryItem::select('inventory_items.company_id','pallets.barcode as plt_barcode',
                                    'inventory_items.document_id','inventory_items.product_code','inventory_items.location_code',DB::raw("SUM(qty_1count) as qty1"),
                                    DB::raw("SUM(qty_2count) as qty2"),DB::raw("SUM(qty_3count) as qty3"),
                                    DB::raw("SUM(qty_wms) as qty_wms"),DB::raw("SUM(qty_4count) as qty4"),'labels.barcode as label_barcode',
                                    'inventory_items.created_at', 'description', 'deposit_code', 'inventory_status_id', 'inventory_items.uom_code')
                            ->join('inventory_status','inventory_status.id','inventory_items.inventory_status_id')
                            ->join('locations', function($join){
                                $join->on('locations.code','inventory_items.location_code')
                                     ->whereColumn('locations.company_id','inventory_items.company_id');
                            })
                            ->leftJoin('pallets', 'pallets.id', 'inventory_items.pallet_id')
                            ->leftJoin('labels', 'labels.id', 'inventory_items.label_id')
                            ->where('inventory_items.company_id', Auth::user()->company_id)
                            ->where('inventory_items.document_id', $document_id)
                            ->where('inventory_items.inventory_status_id', '<>' ,9)
                            ->groupBy('inventory_items.company_id', 
                                      'inventory_items.product_code',
                                      'location_code',
                                      'inventory_items.created_at',
                                      'description',
                                      'pallets.barcode',
                                      'labels.barcode',
                                      'inventory_items.id')
                            ->orderBy('deposit_code')
                            ->get();
    }


}
