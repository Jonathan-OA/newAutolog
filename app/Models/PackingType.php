<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class PackingType
 * @package App\Models
 * @version March 2, 2018, 1:51 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string code
 * @property string description
 * @property decimal tare
 * @property decimal capacity_kg
 * @property decimal capacity_m3
 * @property decimal capacity_un
 * @property decimal height
 * @property decimal width
 * @property decimal lenght
 */
class PackingType extends Model
{
    public $table = 'packing_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'code',
        'company_id',
        'description',
        'tare',
        'label_type_code',
        'capacity_kg',
        'capacity_m3',
        'capacity_un',
        'height',
        'width',
        'lenght'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'label_type_code' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os packing_types disponíveis
     public static function getPackingTypes(){
        return PackingType::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->pluck('description_f','code');
    }


}
