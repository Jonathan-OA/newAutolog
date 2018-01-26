<?php

namespace App\Models;

use Eloquent as Model;
use Auth;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Pallet
 * @package App\Models
 * @version January 17, 2018, 5:57 pm UTC
 */
class Pallet extends Model
{
    public $table = 'pallets';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'barcode',
        'date',
        'status',
        'location_code',
        'document_id',
        'height',
        'stacking',
        'packing_type_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'barcode' => 'string',
        'location_code' => 'string',
        'packing_type_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os pallets disponíveis
     public static function getPallets(){
        return Pallet::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                     ->where('company_id', Auth::user()->company_id)
                     ->pluck('description_f','code');
    }


}
