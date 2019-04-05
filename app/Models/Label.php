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
        'layout_code',
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
        'prim_uom_code' => 'string',
        'serial_number' => 'string',
        'batch' => 'string',
        'batch_supplier' => 'string',
        'layout_code' => 'string',
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
                       ->orderBy('start_date', 'desc')
                       ->get();
    }

    

     //Retorna todos os labels disponíveis
     public static function getLabels(){
        return Label::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
