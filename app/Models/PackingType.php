<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PackingType
 * @package App\Models
 * @version November 22, 2017, 4:45 pm UTC
 */
class PackingType extends Model
{
    public $table = 'packing_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'description',
        'tare',
        'capacity_kg',
        'capacity_m3',
        'height',
        'width',
        'lenght'
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

    //Retorna todas as embalagens disponiveis
    public static function getPackingTypes(){
        return PackingType::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                          ->pluck('description_f','code');
    }
}
