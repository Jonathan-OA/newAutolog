<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Moviment
 * @package App\Models
 * @version March 1, 2018, 7:25 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string code
 * @property string description
 */
class Moviment extends Model
{

    public $table = 'moviments';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



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

    //Retorna todos os $TABLE_NAME$ disponíveis
    public static function getMoviments(){
        return Moviment::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                       ->pluck('description_f','code');
    }
}
