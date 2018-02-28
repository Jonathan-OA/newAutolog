<?php

namespace App\Models;

use Eloquent as Model;
use Auth;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Finality
 * @package App\Models
 * @version February 27, 2018, 7:08 pm BRT
 */
class Finality extends Model
{
    public $table = 'finalities';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os finalitys disponíveis
     public static function getFinalities(){
        return Finality::all()
                      ->pluck('code','code');
    }


}
