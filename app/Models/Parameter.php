<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

/**
 * Class Parameter
 * @package App\Models
 * @version August 4, 2017, 2:20 pm UTC
 */
class Parameter extends Model
{
    public $table = 'parameters';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'code',
        'description',
        'value',
        'def_value',
        'module_name',
        'operation_code'
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
        'description' => 'string',
        'value' => 'string',
        'def_value' => 'string',
        'module_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
     public static $rules = [
        'code' => 'required|string|max:25',
        'operation_code' => 'required|exists:operations,code',
        'description' => 'required|string|max:50',
        'value' => 'required|string|max:100',
    ];

    /**
     * Função que retorna o valor do parâmetro indicado
     * Parâmetros: Código do Parâmetro e o ID da empresa/filial
     * @var array
     */

    public static function getParam($code, $company_id = ''){
        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        $param = Parameter::where([
                                    ['company_id', $company_id],
                                    ['code',$code]
                                ])
                                ->get();
        if(count($param) == 0){
            return '';
        }else{
            return $param[0]->value;
        }
    }
    
}
