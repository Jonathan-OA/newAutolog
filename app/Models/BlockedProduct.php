<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class BlockedProduct
 * @package App\Models
 * @version June 12, 2018, 10:57 am -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property string operation_code
 * @property string product_code
 */
class BlockedProduct extends Model
{
    public $table = 'blocked_products';
    
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

    

     //Retorna todos os blocked_products disponíveis
     public static function getBlockedProducts(){
        return BlockedProduct::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
