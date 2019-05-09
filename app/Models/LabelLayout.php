<?php

namespace App\Models;

use Eloquent as Model;
use Auth;
use DB;


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
     * Variáveis disponíveis para substituição nos layouts
     *
     * @var array
     */
    public static $variables = array('PRDCAD' => array(
                                        'size' => '10',
                                        'table' => 'products', 
                                        'field' => 'code'),
                                     'CLIENTE' => array(
                                        'size' => '10',
                                        'table' => 'customers', 
                                        'field' => 'name'),
                                     'UMVLONG' => array(
                                        'size' => '10',
                                        'table' => 'labels', 
                                        'field' => 'barcode'));
    

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
     * Substitui o layout da etiqueta pelas variáveis
     *
     *
     * @var array
     */
    public static function subCommands($label_commands, $infos){

        //Pega todas as variaveis presentes no  layout
        preg_match_all("/%(.*?)%/", $label_commands, $matches);   
        $variables = $matches[1];

        //Pega informações das variaveis presentes no layout e que estão cadastradas no banco(Label_Variables)
        $variablesList = LabelVariable::getLabelVariables($variables);

        //Loop nas variaveis q estão no layout e no banco
        foreach($variablesList as $val){
            //Nome da Variável
            $name = $val['code'];
            //Tabela e campo de onde deve ser retirado seu valor (que vem no resultado da query $info)
            $field =  $val['table'].'.'.$val['field'];
            //Tamanho limite da Variável
            $size = $val['size'];
            //Ínicio do corte onde o tamanho $size deve ser aplicado.
            $size_start = $val['size_start'];

            //Valor: Buscando o Field cadastrado e cortando na qde correta de caracteres
            $value = substr($infos[0]->$field,$size_start,$size);    

            if($value != ''){
                //Se o valor existir, realiza a substituição
                $label_commands = str_replace('%'.$name.'%',$value,$label_commands);
            }
            
        }
        print_r($label_commands);
        //return $infos;
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