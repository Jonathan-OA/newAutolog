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
     * Variáveis disponíveis para substituição nos layouts
     *
     * @var array
     */
    public static $variables = array('DOCNUM' => array(
                                     'size' => '10',
                                     'table' => 'documents', 
                                     'field' => 'number'),
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
    public static function subCommands($label_commands, $table_base, $params){
        // $table_base indica a tabela principal para buscar os valores
        // $params é um array  que pode conter os seguintes parâmetros como índices:
        // 'label_id', 'location_code', 'pallet_id', 'operation_code', 'document_id'

        $variablesList = App\Models\LabelLayout::$variables;

        //Pega todas as variaveis do layout
        preg_match_all("/%(.*?)%/", $labelLayout->commands, $matches);   
        $variables = $matches[1];
        foreach($variables as $val){
            echo '----'.$val.'---- ';
            if(!array_key_exists($val,$variablesList)){
                echo 'Não Existe;';
            }else{
                echo 'Existe';
            }
        }


        switch($table_base){
            case 'documents':
            $infos = DB::table('documents')
                       ->leftJoin('customers', function ($join) {
                            $join->on('customers.code','documents.customer_code')
                                 ->whereColumn('customers.company_id','documents.company_id');
                       })
                       ->leftJoin('suppliers', function ($join) {
                            $join->on('suppliers.code','documents.supplier_code')
                                 ->whereColumn('suppliers.company_id','documents.company_id');
                       })
                       ->leftJoin('couriers', function ($join) {
                            $join->on('couriers.code','documents.courier_code')
                                 ->whereColumn('couriers.company_id','documents.company_id');
                       })
                       ->where('documents.id', $params['document_id'])
                       ->get();

            break;
            case 'locations':


            break;
            case 'pallets':


            break;
            case 'labels':


            break;



        }
       
        ->where(function ($query) {
            if(trim($GLOBALS['tipoEstq']) <> ''){
                 $query->where('locations.stock_type_code',$GLOBALS['tipoEstq']);
            }
         });

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