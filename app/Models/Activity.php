<?php

namespace App\Models;

use Eloquent as Model;
use Carbon\Carbon;
use Auth;
use DB;


/**
 * Class Activity
 * @package App\Models
 * @version August 23, 2018, 6:01 pm -03
 *
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
 * @property bigInteger task_id
 * @property integer user_id
 * @property string|\Carbon\Carbon date
 * @property string description
 * @property bigInteger document_id
 * @property bigInteger document_item_id
 * @property bigInteger label_id
 * @property bigInteger pallet_id
 * @property decimal qty
 * @property integer reason_id
 */
class Activity extends Model
{
    public $table = 'activities';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'task_id',
        'user_id',
        'start_date',
        'end_date',
        'description',
        'document_id',
        'document_item_id',
        'liberation_item_id',
        'inventory_item_id',
        'product_code',
        'label_id',
        'pallet_id',
        'qty',
        'activity_status_id',
        'reason_id',
        'count'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'user_id' => 'integer',
        'description' => 'string',
        'reason_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * Função que cria uma atividade
     * Parâmetros: ID Tarefa, Produto, Etiqueta, Pallet, Quantidade, Descrição, Documento, Item, Endereço, Status, Contagem, ID Motivo, Usuário
     * @var array
     */
    public static function create($task_id ,$product, $label_id, $pallet_id, $qty, $description, $document_id = NULL,
                                  $document_item_id = NULL, $location = NULL, $liberation_item_id = NULL, $inventory_item_id = NULL,
                                  $status = 8, $count = 1,$reason_id = NULL, $user_id = NULL ){
        //Caso não venha usuário, considera o logado
        $user_id = (trim($user_id == ''))?Auth::user()->id: $user_id;
        $data = Carbon::now();

        $actv = new Activity();
        $actv->company_id = Auth::user()->company_id;
        $actv->task_id = $task_id;
        $actv->user_id = $user_id;
        $actv->product_code = $product;
        $actv->label_id = $label_id;
        $actv->pallet_id = $pallet_id;
        $actv->qty = $qty;
        $actv->start_date = $data;
        $actv->description = $description;
        $actv->document_id = $document_id;
        $actv->document_item_id = $document_item_id;
        $actv->liberation_item_id = $liberation_item_id;
        $actv->inventory_item_id = $inventory_item_id;
        $actv->location_code = $location;
        $actv->activity_status_id = $status;
        $actv->reason_id = $reason_id;
        $actv->count = $count;
        $actv->save();
        return $actv;
    }

    

     /**
     * Função que retorna informações sobre todas as atividades de uma tarefa
     * Parâmetros: ID do documento (opcional)
     * @var array
     */
    public static function getActivities($task_id){
        $actvs =  Activity::select('activities.id','activities.description','activities.start_date','activities.qty',
                                   'activities.label_id','pallets.barcode as pallet_barcode','documents.number',
                                   'document_items.product_code', 'users.user_code','labels.barcode as label_barcode',
                                   'products.code as product_code', 'activity_status_id', 'locations.code as location_code',
                                   'activity_status.description as status_description')
                      ->join('tasks', 'tasks.id', 'activities.task_id')  
                      ->join('users', 'users.id', 'activities.user_id')  
                      ->leftJoin('documents', 'documents.id', 'activities.document_id')  
                      ->leftJoin('document_items', 'document_items.id', 'activities.document_item_id')  
                      ->leftJoin('pallets', 'pallets.id', 'activities.pallet_id')  
                      ->leftJoin('labels', 'labels.id', 'activities.label_id')  
                      ->leftJoin('activity_status', 'activity_status.id', 'activities.activity_status_id')  
                      ->leftJoin('products', function ($join) {
                            $join->on('products.code', '=', 'activities.product_code')
                                 ->whereColumn('products.company_id','activities.company_id');
                      })
                      ->leftJoin('locations', function ($join) {
                                $join->on('locations.code', '=', 'activities.location_code')
                                    ->whereColumn('locations.company_id','activities.company_id');
                      })
                      ->where('activities.company_id', Auth::user()->company_id)
                      ->where('activities.task_id', $task_id)
                      ->get()
                      ->toArray();
        return $actvs;
    }

     /**
     * Função que cancela as activities de um endereço
     * Parâmetros: ID do documento, Location_code
     * @var array
     */
    public static function returnActivitiesLocation($document_id, $location_code){

        return $updAct = Activity::where('company_id', Auth::user()->company_id)
                        ->where('document_id', $document_id)
                        ->where('location_code', $location_code)
                        ->where('activity_status_id', 8)
                        ->update([
                            'activity_status_id' => 9
                        ]);

    }


     /**
     * Retorna todos os itens a serem ajustados em um documento desconsiderando o status do parâmetro
     *
     * @var array
     */

    public static function getItensAudit($document_id, $location_code)
    {

        return Activity::select(
            'inventory_items.id',
            'activities.company_id',
            'activities.document_id',
            'activities.location_code',
            'inventory_items.product_code',
            'products.description',
            'activities.barcode',
            DB::raw("format(qty_wms, uoms.decimal_places) as qty_wms"),
            DB::raw("format(qty_1count, uoms.decimal_places) as qty_1count"),
            DB::raw("format(qty_2count, uoms.decimal_places) as qty_2count"),
            'locations.deposit_code',
            DB::raw("sum(format(prim_qty, uoms.decimal_places)) as total"),
            DB::raw("max(activities.id) as activity_id")
            )
            ->join('inventory_items', 'inventory_items.id', 'activities.inventory_item_id')
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
                $join->on('activities.prim_uom_code', 'uoms.code');
            })
            ->where('inventory_items.company_id', Auth::user()->company_id)
            ->where('activities.document_id', $document_id)
            ->where('inventory_items.location_code', $location_code)
            ->where('activities.location_code', $location_code)
            ->where('activities.activity_status_id', 8)
            ->where('activities.description', 'not like', 'Cancelamento%')
            ->groupBy(
                'activities.company_id',
                'activities.product_code',
                'activities.location_code',
                'activities.document_id',
                'inventory_items.id',
                'inventory_items.product_code',
                'activities.barcode',
                'products.description',
                'qty_wms',
                'qty_1count',
                'qty_2count',
                'locations.deposit_code',
                'uoms.decimal_places'
            )
            ->get()
            ->toArray();
    }



}
