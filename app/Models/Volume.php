<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class Volume
 * @package App\Models
 * @version March 28, 2018, 4:04 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property string barcode
 * @property bigInteger document_id
 * @property string|\Carbon\Carbon date
 * @property smallInteger status
 * @property bigInteger label_id
 * @property string location_code
 * @property decimal height
 * @property smallInteger stacking
 * @property string packing_type_code
 */
class Volume extends Model
{
    public $table = 'volumes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
	
    public $fillable = [
        'company_id',
        'barcode',
        'document_id',
        'volume_status_id',
        'location_code',
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

    

     //Retorna todos os volumes disponíveis
     public static function getVolumes(){
        return Volume::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
