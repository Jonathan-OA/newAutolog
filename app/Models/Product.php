<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;
use Lang;
use Carbon\Carbon;


/**
 * Class Product
 * @package App\Models
 * @version November 29, 2017, 12:48 pm UTC
 */
class Product extends Model
{
    public $table = 'products';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at','due_date','critical_date1','critical_date2','critical_date3','ripeness_date','inventory_date'];


    public $fillable = [
        'company_id',
        'code',
        'description',
        'status',
        'product_type_code',
        'group_code',
        'subgroup_code',
        'margin_div',
        'cost',
        'phase_code',
        'abz_code',
        'inventory_date',
        'due_date',
        'critical_date1',
        'critical_date2',
        'critical_date3',
        'ripeness_date',
        'inspection',
        'obs1',
        'obs2',
        'obs3',
        'obs4',
        'obs5'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'code' => 'string',
        'description' => 'string',
        'product_type_code' => 'string',
        'group_code' => 'string',
        'subgroup_code' => 'string',
        'phase_code' => 'string',
        'abz_code' => 'string',
        'inspection' => 'integer',
        'obs1' => 'string',
        'obs2' => 'string',
        'obs3' => 'string',
        'obs4' => 'string',
        'obs5' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];

    /**
     * Função que valida o código de produto lido (Retorna o array com as informações ou false caso não encontre o item)
     * Parâmetros: Barcode a ser procurado e o ID da empresa / filial logada
     * Retorno: Código do erro, mensagem de erro e informações da etiqueta
     * @var array
     */

    public static function valCBPD( $barcode, $company_id = ''){

        //Barcode pode ser uma etiqueta, barcode da prdemb ou código do produto
        //Caso seja uma etiqueta, o status tem q ser diferente de 9
        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        $ret['erro'] = 0;
        $infos = DB::table('labels')->join('products', function ($join) {
                                        $join->on('products.code', '=', 'labels.product_code')
                                             ->whereColumn ('products.company_id','labels.company_id');
                                    })
                                    ->join('packings', function ($join) {
                                        $join->on('labels.product_code', '=', 'packings.product_code')
                                             ->whereColumn('labels.uom_code','packings.uom_code')
                                             ->whereColumn ('labels.company_id','packings.company_id');
                                    })
                                    ->where([
                                        ['labels.company_id', $company_id],
                                        ['labels.barcode', '=', $barcode],
                                        ['labels.label_status_id', '<>', 9]
                                    ])
                                    ->orWhere('labels.id', (int)$barcode)
                                    ->select('labels.id as label_id', 'labels.product_code','products.description','labels.qty','labels.uom_code',
                                             'labels.prev_qty','labels.prev_uom_code','labels.batch','labels.batch_supplier',
                                             'labels.serial_number','labels.prod_date','labels.due_date','labels.origin',
                                             'packings.conf_batch','packings.conf_batch_supplier','packings.conf_serial','packings.create_label',
                                             'packings.conf_due_date','packings.conf_prod_date','labels.label_status_id as label_status',
                                             'products.group_code', 'products.product_type_code','packings.label_type_code', 'labels.due_date')
                                    ->get();   
                                                          
        if(count($infos) == 0){
            //Não achou etiqueta com esse código, busca na tabela de embalagens
            $infos = DB::table('packings')->join('products', function ($join) {
                                                $join->on('products.code', '=', 'packings.product_code')
                                                     ->whereColumn ('products.company_id','packings.company_id');
                              })
                              ->join('packings as prevL', function ($join) {
                                        $join->on('products.code', '=', 'prevL.product_code')
                                             ->whereColumn ('products.company_id','prevL.company_id')
                                             ->whereColumn ('packings.prev_level','prevL.level')
                                             ;
                              })
                              ->where([
                                    ['packings.company_id', $company_id],
                                    ['packings.barcode', '=', $barcode]
                              ])
                              ->select( DB::raw("'' as label_id"), 'packings.product_code','products.description',
                                        DB::raw('1 as qty'),'packings.uom_code','packings.prev_qty','prevL.uom_code as prev_uom_code',
                                        'packings.conf_batch','packings.conf_batch_supplier','packings.conf_serial','packings.create_label',
                                        'packings.conf_due_date','packings.conf_prod_date',DB::raw("'' as batch"),DB::raw("'' as batch_supplier"),
                                        DB::raw("'' as serial_number"),DB::raw("'' as prod_date"), DB::raw("'' as due_date"),
                                        DB::raw("0 as label_status"),'products.group_code', 'products.product_type_code','packings.label_type_code')
                              ->get();

            if(count($infos) == 0){
                //Não achou embalagem, procura produto
                $infos = DB::table('products')->join('packings', function ($join) {
                                                    $join->on('products.code', '=', 'packings.product_code')
                                                         ->whereColumn ('products.company_id','packings.company_id')
                                                         ->where ('packings.level','=','1');
                                  })
                                  ->where([
                                        ['products.company_id', $company_id],
                                        ['products.code', '=', $barcode]
                                  ])
                                  ->select( DB::raw("'' as label_id"), 'packings.product_code','products.description',
                                         DB::raw('1 as qty'),'packings.uom_code','packings.prev_qty','packings.uom_code as prev_uom_code',
                                        'packings.conf_batch','packings.conf_batch_supplier','packings.conf_serial','packings.create_label',
                                        'packings.conf_due_date','packings.conf_prod_date',DB::raw("'' as batch"),DB::raw("'' as batch_supplier"),
                                        DB::raw("'' as serial_number"),DB::raw("'' as prod_date"), DB::raw("'' as due_date"), 
                                        DB::raw("0 as label_status"),'products.group_code', 'products.product_type_code','packings.label_type_code')
                                  ->get(); 
                if(count($infos) == 0){
                    //Não encontrou registros - Erro
                    $ret['erro'] = 1;
                    $ret['msg_erro'] = Lang::get('validation.cb_error');
                    $infos[0] = '';
                }
            }
        }else{
            //Se achou a etiqueta, verifica data de validade
            if(!empty($infos[0]->due_date)){
                if(Carbon::now() > $infos[0]->due_date){
                    $ret['erro'] = 2;
                    $ret['msg_erro'] = Lang::get('validation.dataval_error');
                }
            }
        }

        $ret['infos'] = (array)$infos[0];
        return $ret;

    }

    
}
