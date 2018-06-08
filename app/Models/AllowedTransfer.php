<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class AllowedTransfer
 * @package App\Models
 * @version May 28, 2018, 3:12 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property string orig_department_code
 * @property string orig_deposit_code
 * @property string dest_department_code
 * @property string dest_deposit_code
 * @property string operation_code
 * @property string document_type_code
 * @property boolean reset_stock
 * @property boolean export_erp
 * @property string operation_erp
 * @property string cost_center
 * @property string logical_deposit
 * @property boolean enabled
 */
class AllowedTransfer extends Model
{
    public $table = 'allowed_transfers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'orig_department_code',
        'orig_deposit_code',
        'dest_department_code',
        'dest_deposit_code',
        'operation_code',
        'document_type_code',
        'reset_stock',
        'export_erp',
        'operation_erp',
        'cost_center',
        'logical_deposit',
        'enabled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'orig_department_code' => 'string',
        'orig_deposit_code' => 'string',
        'dest_department_code' => 'string',
        'dest_deposit_code' => 'string',
        'operation_code' => 'string',
        'document_type_code' => 'string',
        'reset_stock' => 'boolean',
        'export_erp' => 'boolean',
        'operation_erp' => 'string',
        'cost_center' => 'string',
        'logical_deposit' => 'string',
        'enabled' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os allowed_transfers disponíveis
     public static function getAllowedTransfers(){
        return AllowedTransfer::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }

    //Valida se a regra de trânsferencia já existe
    public static function extAllowedTransfer($transf){
        
        $exists = AllowedTransfer::where('company_id', Auth::user()->company_id)
                                 ->where('orig_department_code', $transf['orig_department_code'])
                                 ->where('orig_deposit_code', $transf['orig_deposit_code'])
                                 ->where('dest_department_code', $transf['dest_department_code'])
                                 ->where('dest_deposit_code', $transf['dest_deposit_code'])
                                 ->where('operation_code', $transf['operation_code'])
                                 ->count();
        
        return $exists;

    }

}
