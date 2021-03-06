<?php

namespace App\Models;

use Eloquent as Model;
use Auth;
use Carbon\Carbon;
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
        'date_4count',
        'prim_uom_code'
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
    public static $rules = [];


    /**
     * Retorna todos os itens disponíveis em um documento desconsiderando o status do parâmetro
     *
     * @var array
     */

    public static function getItens($document_id, $statusDsc = '')
    {

        return InventoryItem::select(
            DB::raw("MIN(inventory_items.id) as id "),
            'inventory_items.company_id',
            'document_id',
            'location_code',
            DB::raw("format(SUM(qty_wms), uoms.decimal_places)  as qty"),
            DB::raw("format(SUM(qty_1count), uoms.decimal_places) as qty_1count"),
            DB::raw("format(SUM(qty_2count), uoms.decimal_places) as qty_2count"),
            'deposit_code'
        )
            ->join('inventory_status', 'inventory_status.id', 'inventory_items.inventory_status_id')
            ->join('locations', function ($join) {
                $join->on('locations.code', 'inventory_items.location_code')
                    ->whereColumn('locations.company_id', 'inventory_items.company_id');
            })
            ->join('products', function ($join) {
                $join->on('products.code', 'inventory_items.product_code')
                    ->whereColumn('products.company_id', 'inventory_items.company_id');
            })
            ->join('uoms', function ($join){
                $join->on('inventory_items.uom_code', 'uoms.code');
            })
            ->where('inventory_items.company_id', Auth::user()->company_id)
            ->where('document_id', $document_id)
            ->where(function ($query) {
                if (!empty($statusDsc)) {
                    $query->where('inventory_status_id.id', '<>', $statusDsc);
                }
            })
            ->where(function ($query) {
                $query->where("inventory_items.qty_wms", ">", 0)
                    ->orWhere(function ($query) {
                        $query->where("inventory_items.qty_1count", ">", "0")
                            ->orWhere("inventory_items.qty_2count", ">", "0")
                            ->orWhere("inventory_items.qty_3count", ">", "0")
                            ->orWhere("inventory_items.qty_4count", ">", "0");
                    });
            })
            ->groupBy(
                'inventory_items.company_id',
                'document_id',
                'location_code',
                'deposit_code',
                'uoms.decimal_places'
            )
            ->get()
            ->toArray();
    }

    /**
     * Retorna todos os itens a serem ajustados em um documento desconsiderando o status do parâmetro
     *
     * @var array
     */

    public static function getItensAudit($document_id, $location_code)
    {

        return InventoryItem::select(
            'inventory_items.id',
            'inventory_items.company_id',
            'document_id',
            'location_code',
            'inventory_items.product_code',
            'products.description',
            DB::raw("format(qty_wms, uoms.decimal_places) as qty_wms"),
            DB::raw("format(qty_1count, uoms.decimal_places) as qty_1count"),
            DB::raw("format(qty_2count, uoms.decimal_places) as qty_2count"),
            'deposit_code'
        )
            ->join('inventory_status', 'inventory_status.id', 'inventory_items.inventory_status_id')
            ->join('locations', function ($join) {
                $join->on('locations.code', 'inventory_items.location_code')
                    ->whereColumn('locations.company_id', 'inventory_items.company_id');
            })
            ->join('products', function ($join) {
                $join->on('products.code', 'inventory_items.product_code')
                    ->whereColumn('products.company_id', 'inventory_items.company_id');
            })
            ->join('uoms', function ($join){
                $join->on('inventory_items.uom_code', 'uoms.code');
            })
            ->where('inventory_items.company_id', Auth::user()->company_id)
            ->where('document_id', $document_id)
            ->where('inventory_items.location_code', $location_code)
            ->where(function ($query) {
                $query->where("inventory_items.qty_wms", ">", 0)
                    ->orWhere(function ($query) {
                        $query->where("inventory_items.qty_1count", ">", "0")
                            ->orWhere("inventory_items.qty_2count", ">", "0")
                            ->orWhere("inventory_items.qty_3count", ">", "0")
                            ->orWhere("inventory_items.qty_4count", ">", "0");
                    });
            })
            ->get()
            ->toArray();
    }

    /**
     * Retorna as leituras realizadas no inventário
     *
     * @var document_id e @var count 
     */

    public static function getAppointments($document_id, $count = 1, $summarize = 0)
    {
        switch ($count) {
            case 2:
                $status = array(1, 21);
                break;
            case 3:
                $status = array(1, 2, 31);
                break;
            default:
                $status = '';
        }
        if ($summarize == 0) {
            return Activity::select(
                'activities.company_id',
                'pallets.barcode as plt_barcode',
                'activities.document_id',
                'activities.location_code',
                DB::raw("format(SUM(activities.prim_qty), uoms.decimal_places) as qty1"),
                'users.name',
                DB::raw("0 as qty2"),
                DB::raw("0 as qty3"),
                DB::raw("format(SUM(products.qty_erp), uoms.decimal_places) as qty_wms"),
                DB::raw("0 as qty4"),
                'labels.barcode as label_barcode',
                'activities.created_at',
                'activity_status.description as description',
                'deposit_code',
                'activity_status_id',
                'activities.prim_uom_code',
                DB::raw('CASE WHEN products.customer_code IS NOT NULL AND products.alternative_code IS NOT NULL THEN products.alternative_code ELSE activities.product_code END as product_code'),
                'products.description as product_description',
                'activities.barcode'
                )
                ->join("uoms", "activities.prim_uom_code", "uoms.code")
                ->join('activity_status', 'activity_status.id', 'activities.activity_status_id')
                ->join('locations', function ($join) {
                    $join->on('locations.code', 'activities.location_code')
                        ->whereColumn('locations.company_id', 'activities.company_id');
                })
                ->join('products', function ($join) {
                    $join->on('products.code', 'activities.product_code')
                        ->whereColumn('products.company_id', 'activities.company_id');
                })
                ->leftJoin('users', function ($join) {
                    $join->on('users.id', 'activities.user_id')
                        ->whereColumn('users.company_id', 'activities.company_id');
                })
                ->leftJoin('pallets', 'pallets.id', 'activities.pallet_id')
                ->leftJoin('labels', 'labels.id', 'activities.label_id')
                ->where('activities.company_id', Auth::user()->company_id)
                ->where('activities.document_id', $document_id)
                ->where('activities.activity_status_id', '<>', 9)
                ->where('activities.description', 'not like', 'Cancelamento%')
                ->where("activities.prim_qty", ">", 0)
                ->where("activities.count", $count)
                ->groupBy(
                    'activities.company_id',
                    'activities.product_code',
                    'location_code',
                    'activities.created_at',
                    'activity_status.description',
                    'pallets.barcode',
                    'labels.barcode',
                    'activities.id',
                    'activities.user_id',
                    'users.name',
                    'activities.barcode'
                )
                ->orderBy('location_code')
                ->get();
        } else {
            return InventoryItem::select(
                'inventory_items.company_id',
                'pallets.barcode as plt_barcode',
                'inventory_items.document_id',
                DB::raw("'' as location_code"),
                DB::raw("format(SUM(qty_1count), uoms.decimal_places) as qty1"),
                DB::raw("' ----- ' as name"),
                DB::raw("format(SUM(qty_2count), uoms.decimal_places) as qty2"),
                DB::raw("format(SUM(qty_3count), uoms.decimal_places) as qty3"),
                DB::raw("format(SUM(distinct products.qty_erp), uoms.decimal_places) as qty_wms"),
                DB::raw("format(SUM(qty_4count), uoms.decimal_places) as qty4"),
                'labels.barcode as label_barcode',
                DB::raw("now() as created_at"),
                'inventory_status.description as description',
                'deposit_code',
                'inventory_status_id',
                'inventory_items.prim_uom_code',
                DB::raw('CASE WHEN products.customer_code IS NOT NULL AND products.alternative_code IS NOT NULL THEN products.alternative_code ELSE inventory_items.product_code END as product_code'),
                'products.description as product_description',
                'packings.barcode'
            )
                ->join("uoms", "inventory_items.prim_uom_code", "uoms.code")
                ->join('inventory_status', 'inventory_status.id', 'inventory_items.inventory_status_id')
                ->join('locations', function ($join) {
                    $join->on('locations.code', 'inventory_items.location_code')
                        ->whereColumn('locations.company_id', 'inventory_items.company_id');
                })
                ->join('products', function ($join) {
                    $join->on('products.code', 'inventory_items.product_code')
                        ->whereColumn('products.company_id', 'inventory_items.company_id');
                })
                ->join('packings', function ($join) {
                    $join->on('products.code', 'packings.product_code')
                    ->whereColumn('products.company_id', 'packings.company_id')
                    ->where('packings.level', 1);
                })
                ->leftJoin('users', function ($join) {
                    $join->on('users.id', 'inventory_items.user_1count')
                        ->whereColumn('users.company_id', 'inventory_items.company_id');
                })
                ->leftJoin('pallets', 'pallets.id', 'inventory_items.pallet_id')
                ->leftJoin('labels', 'labels.id', 'inventory_items.label_id')
                ->where('inventory_items.company_id', Auth::user()->company_id)
                ->where('inventory_items.document_id', $document_id)
                ->where('inventory_items.inventory_status_id', '<>', 9)
                ->where(function ($query) {
                    $query->where("inventory_items.qty_wms", ">", 0)
                        ->orWhere(function ($query) {
                            $query->where("inventory_items.qty_1count", ">", "0")
                                ->orWhere("inventory_items.qty_2count", ">", "0")
                                ->orWhere("inventory_items.qty_3count", ">", "0")
                                ->orWhere("inventory_items.qty_4count", ">", "0");
                        });
                })
                ->when($status, function ($query, $status) {
                    if (count($status) > 0) {
                        $query->whereIn('inventory_items.inventory_status_id', $status);
                    }
                })
                ->groupBy(
                    'inventory_items.company_id',
                    'inventory_items.document_id',
                    'locations.deposit_code',
                    'inventory_items.inventory_status_id',
                    'inventory_items.product_code',
                    'inventory_status.description',
                    'pallets.barcode',
                    'labels.barcode',
                    'inventory_items.user_1count',
                    'products.qty_erp',
                    'inventory_items.prim_uom_code',
                    'products.description',
                    'packings.barcode'
                )
                ->orderBy('products.code')
                ->get();
        }
    }

    /**
     * Retorna os itens pendentes para abertura de proxima contagem (Agrupados por endereço)
     *
     * @var document_id e @var count 
     */

    public static function getItensForCount($document_id, $count = '', $deposits = '', $divMax = '', $divMin = '')
    {
        switch ($count) {
            case 2:
                $status = array(1, 21);
                break;
            case 3:
                $status = array(1, 2, 31);
                break;
            case 4:
                $status = array(1, 2, 3, 41);
                break;
            default:
                $status = '';
        }

        return InventoryItem::select(
            'inv.company_id',
            'inv.document_id',
            'inv.product_code',
            'inv.location_code',
            DB::raw("SUM(inv.qty_1count) as qty1"),
            DB::raw("SUM(inv.qty_2count) as qty2"),
            DB::raw("SUM(inv.qty_3count) as qty3"),
            DB::raw("SUM(inv.qty_wms) as qty_wms"),
            DB::raw("SUM(inv.qty_4count) as qty4"),
            DB::raw("MIN(inv.created_at) as created_at"),
            'inventory_status.description',
            'deposit_code',
            'inv.inventory_status_id',
            'inv.prim_uom_code',
            DB::raw("COUNT(distinct itemsFin.id) as itemsFin"),
            DB::raw("SUM(CASE WHEN inv.inventory_status_id = 8 THEN IFNULL(inv.qty_4count,0) ELSE IFNULL(inv.qty_" . ($count - 1) . "count,0) END - inv.qty_wms) * products.cost as cost"),
            DB::raw("SUM(CASE WHEN inv.inventory_status_id = 8 THEN IFNULL(inv.qty_4count,0) ELSE IFNULL(inv.qty_" . ($count - 1) . "count,0) END - inv.qty_wms)  as diverg")
        )
            ->from('inventory_items as inv')
            ->join('inventory_status', 'inventory_status.id', 'inv.inventory_status_id')
            ->join('locations', function ($join) {
                $join->on('locations.code', 'inv.location_code')
                    ->whereColumn('locations.company_id', 'inv.company_id');
            })
            ->join('products', function ($join) {
                $join->on('products.code', 'inv.product_code')
                    ->whereColumn('products.company_id', 'inv.company_id');
            })
            ->leftJoin('inventory_items as itemsFin', function ($join) {
                $join->on('itemsFin.document_id', 'inv.document_id')
                    ->whereColumn('itemsFin.product_code', 'inv.product_code')
                    ->whereColumn('itemsFin.location_code', 'inv.location_code')
                    ->where('itemsFin.inventory_status_id', '8');
            })
            ->where('inv.company_id', Auth::user()->company_id)
            ->where('inv.document_id', $document_id)
            ->where('inv.inventory_status_id', '<>', 9)
            ->when($status, function ($query, $status) {
                if (!empty($status)) {
                    $query->whereIn('inv.inventory_status_id', $status);
                }
            })
            ->when($deposits, function ($query, $deposits) {
                if (!empty($deposits)) {
                    $query->whereIn('locations.deposit_code', $deposits);
                }
            })
            ->groupBy(
                'inv.company_id',
                'inv.document_id',
                'inv.product_code',
                'inv.location_code',
                'inventory_status.description',
                'deposit_code',
                'inv.inventory_status_id',
                'inv.prim_uom_code'
            )
            ->orderBy('deposit_code')
            ->get();
    }

    /**
     * Retorna os itens pendentes para abertura de proxima contagem
     *
     * @var document_id e @var count 
     */

    public static function getDetItensForCount($document_id, $product_code, $location_code, $count)
    {
        switch ($count) {
            case 2:
                $status = array(1, 21);
                break;
            case 3:
                $status = array(1, 2, 31);
                break;
            default:
                $status = '';
        }

        return InventoryItem::select(
            'inventory_items.company_id',
            'inventory_items.document_id',
            'inventory_items.product_code',
            'inventory_items.location_code',
            'qty_1count',
            'qty_2count',
            'qty_3count',
            'qty_wms',
            'qty_4count',
            'pallets.barcode as plt_barcode',
            'labels.barcode as label_barcode',
            'inventory_items.created_at',
            'description',
            'deposit_code',
            'inventory_status_id',
            'inventory_items.prim_uom_code',
            'inventory_items.uom_code'
        )
            ->join('inventory_status', 'inventory_status.id', 'inventory_items.inventory_status_id')
            ->join('locations', function ($join) {
                $join->on('locations.code', 'inventory_items.location_code')
                    ->whereColumn('locations.company_id', 'inventory_items.company_id');
            })
            ->join('products', function ($join) {
                $join->on('products.code', 'inventory_items.product_code')
                    ->whereColumn('products.company_id', 'inventory_items.company_id');
            })
            ->leftJoin('pallets', 'pallets.id', 'inventory_items.pallet_id')
            ->leftJoin('labels', 'labels.id', 'inventory_items.label_id')
            ->where('inventory_items.company_id', Auth::user()->company_id)
            ->where('inventory_items.document_id', $document_id)
            ->where('inventory_items.inventory_status_id', '<>', 9)
            ->where('inventory_items.product_code', $product_code)
            ->where('inventory_items.location_code', $location_code)
            ->whereIn('inventory_items.inventory_status_id', $status)
            ->orderBy('deposit_code')
            ->get();
    }

    /**
     * Finaliza o inventário do item / endereço
     *
     * @var document_id e @var count 
     */

    public static function closeItem($document_id, $product, $location, $invCount)
    {

        switch ($invCount) {
            case 2:
                $columnQty = "qty_1count";
                break;
            case 3:
                $columnQty = "qty_2count";
                break;
            case 4:
                $columnQty = "qty_3count";
                break;
        }


        $updItem = InventoryItem::where('company_id', Auth::user()->company_id)
            ->where('product_code', $product)
            ->where('document_id', $document_id)
            ->where('location_code', $location)
            ->where('inventory_status_id', '<>', 8)
            ->update([
                'inventory_status_id' => 8,
                'qty_4count' => DB::raw("$columnQty"),
                'date_4count' => Carbon::now(),
                'user_4count' => Auth::user()->id
            ]);
    }

    /**
     * Finaliza o inventário de todos os itens
     *
     * @var document_id e @var count 
     */

    public static function closeItems($document_id)
    {
        $invCount = 1;
        switch ($invCount) {
            case 1:
                $columnQty = "qty_1count";
                break;
            case 2:
                $columnQty = "qty_1count";
                break;
            case 3:
                $columnQty = "qty_2count";
                break;
            case 4:
                $columnQty = "qty_3count";
                break;
        }


        return InventoryItem::where('company_id', Auth::user()->company_id)
            ->where('document_id', $document_id)
            ->where('inventory_status_id', '<>', 9)
            ->update([
                'inventory_status_id' => 8,
                'qty_final' => DB::raw("$columnQty")/*,
                'date_4count' => Carbon::now(),
                'user_4count' => Auth::user()->id*/
            ]);
    }
    /**
     * Libera o item para a próxima contagem
     *
     * @var document_id e @var count 
     */

    public static function nextCount($document_id, $product, $location, $invCount)
    {
        switch ($invCount) {
            case 2:
                $newInvCount = 2;
                $status = array(1, 21);
                $operation_code = '552';
                break;
            case 3:
                $newInvCount = 3;
                $status = array(1, 2, 31);
                $operation_code = '553';
                break;
            case 4:
                $newInvCount = 4;
                $status = array(1, 2, 3, 41);
                $operation_code = '554';
                break;
            default:
                $status = '';
                $operation_code = '';
        }

        try {
            //Cria uma tarefa para cada inventory_item
            $ret = DB::table('tasks')
                ->insertUsing(
                    [
                        'company_id', 'operation_code', 'document_id', 'inventory_item_id',
                        'orig_location_code', 'dest_location_code', 'task_status_id'
                    ],
                    InventoryItem::where('company_id', Auth::user()->company_id)
                        ->where('document_id', $document_id)
                        ->where('product_code', $product)
                        ->where('location_code', $location)
                        ->whereIn('inventory_status_id', $status)
                        ->select(
                            'company_id',
                            DB::raw("$operation_code as operation_code"),
                            'document_id',
                            'id',
                            'location_code',
                            'location_code',
                            DB::raw("1 as task_status_id")
                        )
                );
            if ($ret) {
                //Atualiza inventory_items para proxima contagem
                $updItem = InventoryItem::where('company_id', Auth::user()->company_id)
                    ->where('product_code', $product)
                    ->where('location_code', $location)
                    ->where('document_id', $document_id)
                    ->whereIn('inventory_status_id', $status)
                    ->update(['inventory_status_id' => $newInvCount]);
            }
            return 0;
        } catch (Exception $e) {
            //ERRO
            return 1;
        }
    }

    /**
     * Retorna as contagens de um endereço específico
     *
     * @var document_id e @var location_code 
     */

    public static function returnLocation($document_id, $location_code, $inventory_status_id)
    {

        $updItem = InventoryItem::where('company_id', Auth::user()->company_id)
            ->where('document_id', $document_id)
            ->where('location_code', $location_code)
            ->update([
                'inventory_status_id' => $inventory_status_id,
                'qty_1count' => 0,
                'date_1count' => NULL,
                'user_1count' => NULL

            ]);

        if ($updItem) {
            $return['erro'] = 0;
            $return['msg'] = 'Endereço Retornado com Sucesso.';
        } else {
            $return['erro'] = 1;
            $return['msg'] = 'Erro ao Retornar Endereço';
        }

        return $return;
    }

    /**
     * Retorna os inventários do mês por filial
     *
     * @var document_id e @var count 
     */

    public static function getInventorysByBranch($summarize = 0, $dateMin = 0, $dateMax = 0)
    {
        if ($summarize == 0) {

            $from = ($dateMin <> 0) ? date($dateMin) : 0;
            $to = ($dateMax <> 0) ? date($dateMax) : 0;

            return InventoryItem::select(
                'companies.id',
                'companies.branch',
                'companies.name',
                DB::raw("SUM(qty_1count) as items"),
                DB::raw("COUNT(DISTINCT documents.id) as inventories"),
                DB::raw("IFNULL(SUM(CASE WHEN billing_type = 'VL' THEN qty_1count * inventory_value ELSE 0 END),0) +IFNULL( di.totalFechado, 0) as total"),
                DB::raw("(IFNULL(SUM(CASE WHEN billing_type = 'VL' THEN qty_1count * inventory_value ELSE 0 END),0) +IFNULL( di.totalFechado, 0)) / SUM(qty_1count) as average"),
                DB::raw("(IFNULL(SUM(CASE WHEN billing_type = 'VL' THEN qty_1count * inventory_value ELSE 0 END),0) +IFNULL( di.totalFechado, 0) ) * 0.1 as royalties")
            )
                ->join('documents', 'documents.id', 'inventory_items.document_id')
                ->join('document_types', function ($join) {
                    $join->on('document_types.code', 'documents.document_type_code')
                        ->where('document_types.moviment_code', '090');
                })
                ->join('companies', 'companies.id', 'inventory_items.company_id')
                ->leftJoin(
                    DB::raw('(SELECT company_id, SUM(inventory_value) as totalFechado
                                     FROM documents 
                                     WHERE billing_type = "VF" AND
                                           inventory_status_id NOT IN (9) AND
                                           document_status_id NOT IN (0,1,9) AND 
                                           CASE WHEN "' . $from . '" <> "0" AND "' . $to . '" <> "0" THEN start_date between "' . $from . '" and "' . $to . '"
                                           ELSE 0 = 0 END
                                     GROUP BY company_id) di'),
                    function ($join) {
                        $join->on('di.company_id', '=', 'documents.company_id');
                    }
                )
                ->whereNotIn('documents.document_status_id', [0, 1, 9])
                ->where('documents.inventory_status_id', '<>', 9)
                ->where('inventory_items.inventory_status_id', '<>', 9)
                ->where(function ($query) use ($from, $to) {
                    if (!empty($from) && !empty($to)) {
                        $from = date($dateMin) . " 00:00:00";
                        $to = date($dateMax) . " 23:59:59";
                        $query->whereBetween('documents.start_date', [$from, $to]);
                    }
                })
                ->groupBy(
                    'companies.branch',
                    'companies.name',
                    'companies.id',
                    'di.totalFechado'
                )
                ->orderBy('companies.branch')
                ->get();
        }
    }

    /**
     * Retorna os inventários de um periodo para uma filial especifica
     *
     * @var document_id e @var count 
     */

    public static function getInventorys($company_id = "", $dateMin = "", $dateMax = "")
    {
        if ($company_id != "") {

            return InventoryItem::select(
                'companies.id',
                'companies.branch',
                'companies.name',
                'documents.number',
                'customers.trading_name',
                'documents.start_date',
                'documents.end_date',
                DB::raw("SUM(qty_1count) as items"),
                'documents.billing_type',
                'documents.inventory_value',
                DB::raw(" CASE WHEN billing_type = 'VL' THEN SUM( qty_1count * inventory_value) ELSE inventory_value END as total"),
                DB::raw(" CASE WHEN billing_type = 'VL' THEN SUM( qty_1count * inventory_value) ELSE inventory_value END / SUM(qty_1count) as average"),
                DB::raw(" CASE WHEN billing_type = 'VL' THEN SUM( qty_1count * inventory_value) ELSE inventory_value END * 0.1 as royalties")
            )
                ->join('documents', 'documents.id', 'inventory_items.document_id')
                ->join('customers', function ($join) {
                    $join->on('customers.code', 'documents.customer_code')
                        ->whereColumn('customers.company_id', 'documents.company_id');
                })
                ->join('document_types', function ($join) {
                    $join->on('document_types.code', 'documents.document_type_code')
                        ->where('document_types.moviment_code', '090');
                })
                ->join('companies', 'companies.id', 'inventory_items.company_id')
                ->whereNotIn('documents.document_status_id', [0, 1, 9])
                ->where('inventory_items.inventory_status_id', '<>', 9)
                ->where('documents.inventory_status_id', '<>', 9)
                ->where('documents.company_id', '=', $company_id)

                ->where(function ($query) use ($dateMin, $dateMax) {
                    if (!empty($dateMin) && !empty($dateMax)) {
                        $from = date($dateMin) . " 00:00:00";
                        $to = date($dateMax) . " 23:59:59";
                        $query->whereBetween('documents.start_date', [$from, $to]);
                    }
                })
                ->groupBy(
                    'companies.branch',
                    'companies.name',
                    'companies.id',
                    'documents.number',
                    'customers.trading_name',
                    'documents.end_date',
                    'documents.start_date',
                    'documents.billing_type',
                    'documents.inventory_value'
                )
                ->orderBy('documents.start_date')
                ->get();
        }
    }
}
