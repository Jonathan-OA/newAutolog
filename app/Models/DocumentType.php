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

    

    /**
     * Retorna os tipos de documentos de acordo com o movimento (listagem de inputs)
     *
     * @return Response
     */
    public static function getDocumentTypes($moviment_code = ''){
        $GLOBALS['mov'] = $moviment_code;
        return DocumentType::selectRaw("code,CONCAT(code,' - ',description) as description_f, num_automatic")
                     ->where(function ($query) {
                       if(!empty($GLOBALS['mov'])){
                           $query->where('moviment_code',$GLOBALS['mov']);
                       }
                      })
                     ->pluck('description_f','code','num_automatic');
   }

   /**
     * Retorna os tipos de documentos onde o indice é o Código do tipo
     *
     * @return Response
     */
   public static function getDocumentTypesArray($moviment_code = ''){
        $GLOBALS['mov'] = $moviment_code;
        $ret = [];
        $docTypes =  DocumentType::where(function ($query) {
                                    if(!empty($GLOBALS['mov'])){
                                        $query->where('moviment_code',$GLOBALS['mov']);
                                    }
                                })
                                ->get();
        foreach($docTypes as $docType){
            //Cria array de retorno onde indice principal é o tipo de documento
            $ret[$docType['code']] = ['lib_automatic' => $docType['lib_automatic'], 'lib_location' => $docType['lib_location'],
                                      'num_automatic' => $docType['num_automatic'], 'print_labels' => $docType['print_labels'],
                                      'partial_lib' => $docType['partial_lib'], 'lib_deposits' => $docType['lib_deposits'],
                                      'moviment_code' => $docType['moviment_code']];
        }

        return $ret;
    }

   public static function getMoviment($document_type_code){
    return DocumentType::select("moviment_code")
            ->where('code','=',$document_type_code)
            ->pluck('moviment_code');
   }


}
