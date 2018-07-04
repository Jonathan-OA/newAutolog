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

    

     //Retorna todos os document_type_rules disponíveis
     public static function getDocumentTypeRules(){
        return DocumentTypeRule::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
