<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

/**
 * Class DepositType
 * @package App\Models
 * @version December 21, 2017, 1:43 pm UTC
 */
class DepositType extends Model
{
    public $table = 'deposit_types';
    
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

    //Retorna todos os tipos de depositos disponíveis
    public static function getDepTypes(){
        return DepositType::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                            ->pluck('description_f','code');
    }
    
}
