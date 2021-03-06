<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * Class UserPermission
 * @package App\Models
 * @version October 25, 2017, 6:07 pm UTC
 */
class UserPermission extends Model
{
    public $table = 'user_permissions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_type_code',
        'operation_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_type_code' => 'string',
        'operation_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * Retorna todas as operações cadastradas e as permissões disponíveis para o usuário
     *
     * 
     */
    public static function getPermissions($user_type_code){
        $GLOBALS['userType'] = $user_type_code;
        return DB::table('operations')->leftJoin('user_permissions', function ($join) {
                            $join->on('code', '=', 'operation_code')
                                ->where('user_type_code', '=', $GLOBALS['userType']);
                        })
                        ->orderBy('module_name', 'asc')
                        ->get();
                        
    }
    
}
