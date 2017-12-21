<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

/**
 * Class Sector
 * @package App\Models
 * @version December 21, 2017, 1:47 pm UTC
 */
class Sector extends Model
{
    public $table = 'sectors';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'deposit_code',
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
        'deposit_code' => 'string',
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

     //Retorna todos os setores disponíveis
     public static function getSectors(){
        return Sector::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }

    
}
