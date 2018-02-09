<?php

namespace App\Models;

use Eloquent as Model;
use Auth;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Label
 * @package App\Models
 * @version February 7, 2018, 6:24 pm BRST
 */
class Label extends Model
{
    public $table = 'labels';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'client_id',
        'item_code',
        'qty',
        'uom_code',
        'prim_qty',
        'prim_uom_code',
        'prev_qty',
        'prev_uom_code',
        'document_id',
        'document_item_id',
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
        'status',
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
        'client_id' => 'string',
        'item_code' => 'string',
        'uom_code' => 'string',
        'prim_uom_code' => 'string',
        'prev_uom_code' => 'string',
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

    

     //Retorna todos os labels disponíveis
     public static function getLabels(){
        return Label::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
