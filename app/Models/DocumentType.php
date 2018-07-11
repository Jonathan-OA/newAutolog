<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class DocumentType
 * @package App\Models
 * @version March 1, 2018, 8:10 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string code
 * @property string description
 * @property string moviment_code
 */
class DocumentType extends Model
{
    public $table = 'document_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'code',
        'description',
        'moviment_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string',
        'description' => 'string',
        'moviment_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required|string|unique:document_types,code|max:5',
        'description' => 'required|string|max:50',
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
