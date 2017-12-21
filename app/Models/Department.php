<?php

namespace App\Models;

use Eloquent as Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Department
 * @package App\Models
 * @version December 21, 2017, 1:44 pm UTC
 */
class Department extends Model
{
    public $table = 'departments';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'code',
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

    //Retorna todos os departamentos disponíveis
    public static function getDepartments(){
        return Department::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }
    
}
