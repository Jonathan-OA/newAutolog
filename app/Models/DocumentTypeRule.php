<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class DocumentTypeRule
 * @package App\Models
 * @version July 4, 2018, 1:45 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property string document_type_code
 * @property string liberation_rule_code
 * @property smallInteger order
 */
class DocumentTypeRule extends Model
{
    public $table = 'document_type_rules';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'document_type_code',
        'liberation_rule_code',
        'order'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'document_type_code' => 'string',
        'liberation_rule_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

    /**
     * Função que retorna todas as regras cadastradas para um tipo de documento
     * Parâmetros: Tipo de documento
     * @var array
     */

     public static function getDocumentTypeRules($document_type_code){
        return DocumentTypeRule::select('document_type_rules.id','code', 'description', 'order', 'parameters')
                      ->join('liberation_rules','liberation_rules.code', 'document_type_rules.liberation_rule_code')
                      ->where('document_type_code', $document_type_code)
                      ->where('company_id', Auth::user()->company_id)
                      ->orderBy('order')
                      ->get();
    }

    /**
     * Função que retorna a ordem da ultima regra inserida para o documento
     * Parâmetros: Tipo de documento
     * @var array
     */

    public static function getOrder($document_type_code){
        $max = DocumentTypeRule::where('document_type_code', $document_type_code)
                               ->where('company_id', Auth::user()->company_id)
                               ->max('order');
        
        return (int)$max + 1;

    }

}
