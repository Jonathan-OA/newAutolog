<?php

namespace App\Models;

use Eloquent as Model;
use Auth;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Company
 * @package App\Models
 * @version January 4, 2018, 3:54 pm UTC
 */
class Company extends Model
{
    public $table = 'companies';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'branch',
        'name',
        'cnpj',
        'trading_name',
        'address',
        'number',
        'neighbourhood',
        'city',
        'state',
        'country',
        'zip_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'branch' => 'string',
        'name' => 'string',
        'cnpj' => 'string',
        'trading_name' => 'string',
        'address' => 'string',
        'neighbourhood' => 'string',
        'city' => 'string',
        'state' => 'string',
        'country' => 'string',
        'zip_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * Função que retorna o Company_ID no login após selecionar o banco correto
     * Parâmetros: Code e Branch 
     * @var array
     */
    public static function getCompanyID($code, $branch){

        $id = Company::select('id')
                     ->where('code', $code)
                     ->where('branch', $branch)
                     ->get()
                     ->toArray();
                     
        return (count($id)> 0) ? $id[0]['id'] : 0; 

    }

     //Retorna todos os companies disponíveis
     public static function getCompanies(){
        return Company::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                       ->pluck('description_f','code');
    }


}
