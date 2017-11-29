<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App\Models
 * @version October 25, 2017, 1:04 pm UTC
 */
class User extends Model
{
    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'code',
        'name',
        'password',
        'email',
        'user_type_code',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'code' => 'string',
        'name' => 'string',
        'password' => 'string',
        'email' => 'string',
        'user_type_code' => 'string',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */

    public static $rules = [
        'name' => 'required|max:100',
        'code' => 'required|max:20|unique:users',
        'email' => 'email|max:50',
        'password' => 'required|min:6|confirmed',
        'user_type_code' => 'required|max:10',
    ];


    /**
     * Função que valida se o usuário possui permissão para a atividade
     *
     */

     public static function getPermission($operation, $user_type){
        //Retorna a quantidade de registros para esse tipo de usuário / permissão. Se 0 = não tem permissão
        $result = UserPermission::where('operation_code', $operation)
                                ->where('user_type_code', $user_type)
                                ->count();
        
        if($user_type == 'ADMIN') $result = 1;
        
        return $result;

     }
    
}
