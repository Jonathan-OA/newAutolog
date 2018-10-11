<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class Uom
 * @package App\Models
 * @version February 7, 2018, 5:06 pm BRST
 */
class Uom extends Model
{
    public $table = 'uoms';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'code',
        'description',
        'val_integer',
        'decimal_places'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'description' => 'string',
        'val_integer' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os uoms disponíveis
     public static function getUoms(){
        return Uom::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->pluck('description_f','code');
    }


}
