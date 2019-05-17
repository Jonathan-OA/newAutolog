<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class Packing
 * @package App\Models
 * @version March 2, 2018, 1:40 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property smallInteger level
 * @property string product_code
 * @property string uom_code
 * @property string barcode
 * @property decimal prev_qty
 * @property smallInteger prev_level
 * @property string label_type_code
 * @property decimal total_weight
 * @property decimal total_net_weight
 * @property decimal lenght
 * @property decimal width
 * @property decimal depth
 * @property decimal total_m3
 * @property decimal stacking
 * @property string packing_type_code
 * @property decimal print_label
 * @property decimal create_label
 * @property decimal conf_batch
 * @property decimal conf_weight
 * @property decimal conf_serial
 * @property decimal conf_batch_supplier
 * @property decimal conf_due_date
 * @property decimal conf_prod_date
 * @property decimal conf_length
 * @property decimal conf_width
 * @property decimal conf_height
 */
class Packing extends Model
{
    public $table = 'packings';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'level',
        'product_code',
        'uom_code',
        'barcode',
        'prev_qty',
        'prev_level',
        'prim_qty',
        'label_type_code',
        'total_weight',
        'total_net_weight',
        'lenght',
        'width',
        'depth',
        'total_m3',
        'stacking',
        'packing_type_code',
        'print_label',
        'create_label',
        'conf_batch',
        'conf_weight',
        'conf_serial',
        'conf_batch_supplier',
        'conf_due_date',
        'conf_prod_date',
        'conf_length',
        'conf_width',
        'conf_height'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'product_code' => 'string',
        'uom_code' => 'string',
        'barcode' => 'string',
        'label_type_code' => 'string',
        'packing_type_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * Função que retorna as informações de embalagem para uma UOM específica
     * Parâmetros: Código do produto e o código da unidade
     * @var array
     */
    public static function getLevel($product_code, $uom_code, $company_id = ''){

        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;

        $level = Packing::select('level','uom_code','prev_qty','prev_level','val_integer', 'prim_qty',
                                  'print_label', 'conf_batch', 'conf_batch_supplier','conf_serial',
                                  'conf_width','conf_length', 'conf_due_date','conf_prod_date' )
                        ->join('uoms','uoms.code','packings.uom_code')
                        ->where('company_id', Auth::user()->company_id)
                        ->where('product_code', $product_code)
                        ->where('uom_code', $uom_code)
                        ->get()
                        ->toArray();

        return $level;
    }



     /**
     * Função retorna os detalhes dos níveis de embalagem de um produto
     * Parâmetros: Código do produto e o ID da empresa / filial logada
     * @var array
     */
    public static function getLevels($product_code, $company_id = ''){
        
        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        $levels = Packing::select('level','uom_code','prev_qty','prev_level','val_integer', 'prim_qty')
                         ->join('uoms','uoms.code','packings.uom_code')
                         ->where('company_id', Auth::user()->company_id)
                         ->where('product_code', $product_code)
                         ->get()
                         ->toArray();

        foreach($levels as $level){
            //Cria array de retorno onde indice principal é a unidade de medida (facilitar calculo de saldos)
            //val_integer = Valida se a unidade só aceita valores inteiros
            $ret[$level['uom_code']] = ['level' => $level['level'], 'prev_qty' => $level['prev_qty'],
                                        'prev_level' => $level['prev_level'], 'int' => $level['val_integer'],
                                        'prim_qty' => $level['prim_qty']];
        }

        return $ret;


    }


     //Retorna todos as embalagens disponíveis para o produto
     public static function getPackings($produto){
        return Packing::selectRaw("uom_code,CONCAT(level,' - ',uom_code) as description_f")
                        ->where('company_id', Auth::user()->company_id)
                        ->where('product_code', $produto)
                        ->pluck('description_f','code');
    }


}
