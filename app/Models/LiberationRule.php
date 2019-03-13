<?php

namespace App\Models;

use Eloquent as Model;
use Auth;

/**
 * Class LiberationRule
 * @package App\Models
 * @version March 11, 2019, 1:54 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection blockedOperations
 * @property \Illuminate\Database\Eloquent\Collection deposits
 * @property \Illuminate\Database\Eloquent\Collection layouts
 * @property \Illuminate\Database\Eloquent\Collection parameters
 * @property \Illuminate\Database\Eloquent\Collection userPermissions
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection vehicles
 * @property \Illuminate\Database\Eloquent\Collection volumes
 * @property string code
 * @property string module_name
 * @property string description
 * @property boolean enabled
 */
class LiberationRule extends Model
{

    public $table = 'liberation_rules';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'code',
        'moviment_code',
        'description',
        'enabled',
        'parameters'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'moviment_code' => 'string',
        'description' => 'string',
        'enabled' => 'boolean',
        'parameters' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [    ];

    /**
     * Função que retorna todas as regras disponíveis para um movimento (desconsiderando já cadastradas para o doc)
     * Parâmetros: Tipo de documento
     * @var array
     */

    public static function getLiberationRules($moviment_code, $document_type_code){

        $GLOBALS['doc_type'] = $document_type_code;

        return LiberationRule::select('code', 'description', 'parameters')
                            ->leftJoin('document_type_rules', function ($join) {
                                $join->on('document_type_rules.liberation_rule_code', '=', 'liberation_rules.code')
                                ->where('document_type_rules.document_type_code', $GLOBALS['doc_type'])
                                ->where('document_type_rules.company_id', Auth::user()->company_id);
                            })
                            ->whereNull('document_type_rules.id')
                            ->where('enabled', true)
                            ->where('moviment_code', $moviment_code)
                            ->get();
    }

}
