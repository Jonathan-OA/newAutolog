<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class LabelVariable
 * @package App\Models
 * @version May 8, 2019, 8:54 am -03
 *
 * @property \Illuminate\Database\Eloquent\Collection blockedOperations
 * @property \Illuminate\Database\Eloquent\Collection deposits
 * @property \Illuminate\Database\Eloquent\Collection groups
 * @property \Illuminate\Database\Eloquent\Collection labelLayouts
 * @property \Illuminate\Database\Eloquent\Collection parameters
 * @property \Illuminate\Database\Eloquent\Collection userPermissions
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection vehicles
 * @property \Illuminate\Database\Eloquent\Collection volumes
 * @property string code
 * @property string description
 * @property boolean size
 * @property boolean size_start
 * @property string table
 * @property string field
 */
class LabelVariable extends Model
{
    public $table = 'label_variables';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'code',
        'description',
        'size',
        'size_start',
        'table',
        'field'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string',
        'description' => 'string',
        'size' => 'integer',
        'size_start' => 'integer',
        'table' => 'string',
        'field' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * Retorna as informações de variaveis cadastradas na tabela label_variables
     *
     * @param valNames = Nomes das Variaveis a terem seus valores retornados
     * 
     * @var array
     */
    public static function getLabelVariables(array $valNames){

        return LabelVariable::whereIn('code', $valNames) 
                            ->get()
                            ->toArray();

                  
    }


}