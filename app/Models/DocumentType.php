<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class DocumentType
 * @package App\Models
 * @version July 13, 2018, 1:58 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string code
 * @property string description
 * @property string moviment_code
 * @property boolean lib_automatic
 * @property boolean lib_location
 * @property boolean num_automatic
 * @property boolean print_labels
 * @property boolean partial_lib
 * @property string lib_deposits
 */
class DocumentType extends Model
{
    public $table = 'document_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'id',
        'code',
        'description',
        'moviment_code',
        'lib_automatic',
        'lib_location',
        'num_automatic',
        'print_labels',
        'partial_lib',
        'lib_deposits'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string',
        'description' => 'string',
        'moviment_code' => 'string',
        'lib_automatic' => 'boolean',
        'lib_location' => 'boolean',
        'num_automatic' => 'boolean',
        'print_labels' => 'boolean',
        'partial_lib' => 'boolean',
        'lib_deposits' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required|string|unique:document_types,code|max:5',
        'description' => 'required|string|max:50',
        'moviment_code' => 'required|string|exists:moviments,code|max:5',
    ];

    

    //Retorna todos os document_types disponíveis 
    public static function getDocumentTypes($moviment_code = ''){
        $GLOBALS['mov'] = $moviment_code;
        return DocumentType::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                     ->where(function ($query) {
                       if(!empty($GLOBALS['mov'])){
                           $query->where('moviment_code',$GLOBALS['mov']);
                       }
                      })
                     ->pluck('description_f','code');
   }


}
