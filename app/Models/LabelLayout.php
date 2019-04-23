<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class LabelLayout
 * @package App\Models
 * @version April 17, 2019, 3:15 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection blockedOperations
 * @property \Illuminate\Database\Eloquent\Collection deposits
 * @property \Illuminate\Database\Eloquent\Collection groups
 * @property \Illuminate\Database\Eloquent\Collection parameters
 * @property \Illuminate\Database\Eloquent\Collection userPermissions
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection vehicles
 * @property \Illuminate\Database\Eloquent\Collection volumes
 * @property integer company_id
 * @property string code
 * @property string label_type_code
 * @property string printer_type_code
 * @property string description
 * @property boolean status
 * @property string commands
 * @property decimal width
 * @property decimal height
 * @property smallInteger across
 */
class LabelLayout extends Model
{
    public $table = 'label_layouts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'code',
        'label_type_code',
        'printer_type_code',
        'description',
        'status',
        'commands',
        'width',
        'height',
        'across'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'code' => 'string',
        'label_type_code' => 'string',
        'printer_type_code' => 'string',
        'description' => 'string',
        'status' => 'boolean',
        'commands' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

    /**
     * Retorna os comandos de impressão de um layout de etiqueta para um tipo de impressora especifico
     *
     * @var array
     */
     public static function getCommands($label_type_code, $printer_type){
        return LabelLayout::select('commands')
                    ->where('company_id', Auth::user()->company_id)
                    ->where('label_type_code', $label_type_code)
                    ->where('printer_type_code', $printer_type)
                    ->get();
    }

    /**
     * Retorna os tipos de impressora cadastrados para um tipo de etiqueta especifico
     *
     * @var array
     */
    public static function getPrinters($label_type_code){

        $label_type_code = strtoupper($label_type_code);

        return LabelLayout::selectRaw("printer_type_code,CONCAT(printer_type_code,' - ',printer_types.description) as description_f")
                          ->join('printer_types', 'printer_types.code', 'label_layouts.printer_type_code')
                          ->where('company_id', Auth::user()->company_id)
                          ->where('label_type_code', $label_type_code)
                          ->pluck('description_f','printer_type_code');
    }


}