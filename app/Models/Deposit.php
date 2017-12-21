<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

/**
 * Class Deposit
 * @package App\Models
 * @version December 21, 2017, 1:45 pm UTC
 */
class Deposit extends Model
{
    public $table = 'deposits';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'department_code',
        'code',
        'deposit_type_code',
        'description',
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
        'department_code' => 'string',
        'code' => 'string',
        'deposit_type_code' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

     //Retorna todos os depositos disponíveis
     public static function getDeposits(){
        return Deposit::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }
}
