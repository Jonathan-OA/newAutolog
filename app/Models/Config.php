<?php

namespace App\Models;

use Eloquent as Model;
use Auth;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Config
 * @package App\Models
 * @version January 31, 2018, 9:41 am BRST
 */
class Config extends Model
{
    public $table = 'configs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'description',
        'value'
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

    

    //Retorna todos os configs disponíveis
    public static function getConfigs(){
        return Config::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->pluck('description_f','code');
    }


}
