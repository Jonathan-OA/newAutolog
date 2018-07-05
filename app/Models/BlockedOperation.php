<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class BlockedOperation
 * @package App\Models
 * @version July 5, 2018, 4:17 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property string operation_code
 * @property string product_code
 */
class BlockedOperation extends Model
{
    public $table = 'blocked_operations';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'operation_code',
        'product_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'operation_code' => 'string',
        'product_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os blocked_operations disponíveis
     public static function getBlockedOperations(){
        return BlockedOperation::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
