<?php

namespace App\Models;

use Eloquent as Model;
use Auth;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Label
 * @package App\Models
 * @version February 27, 2018, 10:48 am BRT
 */
class Label extends Model
{
    public $table = 'labels';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['due_date','prod_date','deleted_at','ripeness_date','critical_date1','critical_date2','critical_date3',];


    public $fillable = [
        'company_id',
        'barcode',
        'product_code',
        'qty',
        'uom_code',
        'prim_qty',
        'prim_uom_code',
        'document_id',
        'document_item_id',
        'origin',
        'date',
        'serial_number',
        'batch',
        'batch_supplier',
        'prod_date',
        'due_date',
        'ripeness_date',
        'critical_date1',
        'critical_date2',
        'critical_date3',
        'label_status_id',
        'level',
        'travel_id',
        'task_id',
        'label_type_code',
        'weight',
        'width',
        'lenght',
        'text1',
        'text2',
        'text3',
        'text4',
        'text5'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'barcode' => 'string',
        'product_code' => 'string',
        'uom_code' => 'string',
        'prim_uom_code' => 'stdring',
        'serial_number' => 'string',
        'batch' => 'string',
        'batch_supplier' => 'string',
        'label_type_code' => 'string',
        'text1' => 'string',
        'text2' => 'string',
        'text3' => 'string',
        'text4' => 'string',
        'text5' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

     /**
     * Função que cria uma label de acordo com os parâmetros informados
     *
     * @var array
     */
    public static function create($infos){
        print_r($infos);



    }


    /**
     * Função de Rastreabilidade de Etiquetas
     *
     * @var array
     */
    public static function getTraceability($label_id){
        return Activity::select('labels.barcode', 'tasks.operation_code', 'activities.start_date', 'tasks.orig_location_code',
                                'tasks.dest_location_code', 'pallets.barcode as plt_barcode','users.code as user_code',
                                'operations.description','activities.qty','activities.uom_code')
                       ->join('tasks', 'tasks.id', 'activities.task_id')
                       ->join('users', 'users.id', 'activities.user_id')
                       ->join('labels', 'labels.id', 'activities.label_id')
                       ->join('operations', 'operations.code', 'tasks.operation_code')
                       ->leftJoin('pallets', 'pallets.id', 'activities.pallet_id')
                       ->leftJoin('documents', 'documents.id', 'activities.document_id')
                       ->where([ ['activities.label_id', $label_id],
                                 ['activities.activity_status_id', '<>', 0], 
                                 ['activities.company_id', '=', Auth::user()->company_id]
                               ] 
                       )
                       ->orderBy('start_date', 'asc')
                       ->get();
    }


    /**
     * Função que retorna informações para impressão (em formato de array)
     *
     * @param label_id
     * @var array
     */
    public static function getInfosForPrint($label_id){

        $infos = Label::select('labels.barcode as labels.barcode', 'labels.qty as labels.qty',
                               'labels.uom_code as labels.uom_code','labels.prim_qty as labels.prim_qty',
                               'labels.prim_uom_code as labels.prim_uom_code','labels.batch as labels.batch',
                               'labels.batch_supplier as labels.batch_supplier','labels.serial_number as labels.serial_number',
                               'labels.prod_date as labels.prod_date','labels.due_date as labels.due_date',
                               'labels.width as labels.width','labels.length as labels.length',
                               'labels.obs1 as labels.obs1','labels.obs2 as labels.obs2',
                               'labels.obs3 as labels.obs3','labels.obs4 as labels.obs4',
                               'label_status.description as label_status.description',
                               'labels_origin.barcode as labels.origin','documents.number as documents.number',
                               'documents.document_type as documents.document_type','products.code as products.code',
                               'products.description as  products.description')
                           ->join('products', function ($join) {
                                    $join->on('products.code','labels.product_code')
                                        ->whereColumn('products.company_id','labels.company_id');
                            })
                           ->join('label_status', 'label_status.id', 'labels.label_status_id')
                           ->leftJoin('labels_origin', 'labels_origin.id', 'labels.origin')
                           ->leftJoin('documents', 'documents.id', 'labels.document_id')
                           ->leftJoin('document_items', 'document_items.id', 'labels.document_item_id')
                           ->leftJoin('customers', function ($join) {
                                $join->on('customers.code','documents.customer_code')
                                    ->whereColumn('customers.company_id','documents.company_id');
                           })
                           ->where('labels.id', $label_id)
                           ->where('labels.label_status_id','<>','9')
                           ->get()
                           ->toArray(); 
        
        //Formata os campos de data
        $infos->due_date->format('d/m/Y'); //Validade
        $infos->prod_date->format('d/m/Y'); //Produção

        return $infos;

    }

    //Retorna todos os labels disponíveis
    public static function getLabels(){
        return Label::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
