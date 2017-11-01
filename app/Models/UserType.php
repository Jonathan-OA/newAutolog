<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserType
 * @package App\Models
 * @version October 25, 2017, 1:34 pm UTC
 */
class UserType extends Model
{
    public $table = 'user_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'description',
        'active'
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

    //Retorna todos os tipos de usuários disponíveis
    public static function getUserTypes(){
        return UserType::selectRaw("code,CONCAT(code,' - ',description) as description_f")
        ->where('active', '1')
        ->pluck('description_f','code');
    }

    
}
