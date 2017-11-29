<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductType
 * @package App\Models
 * @version November 29, 2017, 12:52 pm UTC
 */
class ProductType extends Model
{
    public $table = 'product_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //Retorna todos os Tipos de Produtos disponíveis
    public static function getProductTypes(){
        return ProductType::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                            ->pluck('description_f','code');
    }
    
}
