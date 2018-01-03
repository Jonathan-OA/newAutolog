<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class StockType
 * @package App\Models
 * @version December 21, 2017, 4:27 pm UTC
 */
class StockType extends Model
{
    public $table = 'stock_types';
    
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
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //Retorna todas os tipos de estoque
    public static function getStockTypes(){
        return StockType::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                           ->pluck('description_f','code');
    }
    
}
