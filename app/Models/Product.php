<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\Models
 * @version November 29, 2017, 12:48 pm UTC
 */
class Product extends Model
{
    public $table = 'products';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'code',
        'description',
        'status',
        'product_type_code',
        'group_code',
        'subgroup_code',
        'margin_div',
        'cost',
        'phase_code',
        'abz_code',
        'inventory_date',
        'due_date',
        'critical_date1',
        'critical_date2',
        'critical_date3',
        'ripeness_date',
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
        'code' => 'string',
        'description' => 'string',
        'product_type_code' => 'string',
        'group_code' => 'string',
        'subgroup_code' => 'string',
        'phase_code' => 'string',
        'abz_code' => 'string',
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
    public static $rules = [];

    /**
     * Função que valida o código de produto lido
     *
     * @var array
     */

    public static function validaProduto (){

    }

    
}
