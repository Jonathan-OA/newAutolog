<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cache;
use Auth;
use DB;

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
        'remember_token',
        'status'
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
        'remember_token' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */

    public static $rules = [];


    /**
     * Função que valida se o usuário possui permissão para a atividade
     *
     */

     public static function getPermission($operation, $user_type){
        //Retorna a quantidade de registros para esse tipo de usuário / permissão. Se 0 = não tem permissão
        $result = UserPermission::where('operation_code', $operation)
                                ->where('user_type_code', $user_type)
                                ->count();
        
        //Admin tem acesso livre
        if($user_type == 'ADMIN') $result = 1;
        
        return $result;

     }

     //Retorna os dados da filial do usuário atual
    public function getCompanyInfo(){
        $company = Company::where('id', $this->company_id)->get();
        return $company[0];
    }


    // Verifica se o usuário esta logado
    public static function isOnline($id){
        
        $company_code = Auth::user()->getCompanyInfo()->code;
        return (Cache::has('user-is-online-'.$company_code.'-'.$id))? 1 : 0;

    }

     // Pega todos os usuarios logados
     public static function getOnline(){
        
        $company_code = Auth::user()->getCompanyInfo()->code;

       // return Cache::has('user-is-online-'.$company_code.'-'.$this->id);

       $users = User::select('id','code','name','user_type_code')
                    ->where('company_id', Auth::user()->company_id)
                    ->get();

        $arrayUsers = array();

        foreach($users as $user){
            if(Cache::has('user-is-online-'.$company_code.'-'.$user->id)){
                $arrayUsers[] = $user;
            }
        }

        return ($arrayUsers);
    }
    
}
