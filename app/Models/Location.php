<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;

/**
 * Class Location
 * @package App\Models
 * @version December 21, 2017, 1:47 pm UTC
 */
class Location extends Model
{
    public $table = 'locations';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'department_code',
        'deposit_code',
        'sector_code',
        'code',
        'barcode',
        'aisle',
        'column',
        'level',
        'depth',
        'status',
        'location_type_code',
        'location_function_code',
        'abz_code',
        'label_type_code',
        'stock_type_code',
        'sequence_arm',
        'sequence_sep',
        'sequence_inv'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'department_code' => 'string',
        'deposit_code' => 'string',
        'sector_code' => 'string',
        'code' => 'string',
        'barcode' => 'string',
        'aisle' => 'string',
        'column' => 'string',
        'location_type_code' => 'string',
        'location_function_code' => 'string',
        'label_type_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * Função que valida o endereço e retorna se é valido ou se esta inativo / capacidade máxima
     * Parâmetros: Código do endereço a ser validado
     * @var array
     */

    public static function valEnd($barcode,  $product = '', $qde = '', $company_id  =''){

        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        $erro = 0;
        //Busca endereço
        $end = DB::table('locations')->join('location_types','location_types.code','locations.location_type_code')
                                     ->where([
                                               ['locations.company_id', $company_id],
                                               ['locations.code', $barcode]
                                     ])
                                     ->select('locations.code','locations.barcode','locations.status','locations.department_code',
                                              'locations.deposit_code', 'locations.location_type_code', 'locations.sector_code',
                                              'location_types.capacity_qty')
                                     ->get();
        if($end[0]->status <> 1){
            //Endereço Inativo
            $erro = 1;
        }else{
            //Endereço ativo 
            //Valida se grupo do produto é bloqueado para o endereço
            if(trim($product) <> ''){
                $verBlock = DB::table('products')->join('blocked_groups', function ($join) {
                                                         $join->on('products.group_code', '=', 'blocked_groups.group_code')
                                                         ->whereColumn ('products.company_id','blocked_groups.company_id');
                                                 })
                                                 ->where([
                                                            ['products.company_id', $company_id],
                                                            ['products.code', $product],
                                                            ['blocked_groups.deposit_code', $end[0]->deposit_code],
                                                            ['blocked_groups.sector_code', $end[0]->sector_code]
                                                 ])
                                                 ->count();
                if($verBlock > 0){
                    //Endereço não permitido
                    $erro = 2;
                }
            }
            
            if(trim($qde) <> '' && $erro == 0){
                //Pega saldo atual do endereço e compara com a capacidade do tipo
                $capc = Stock::getSald($end[0]->code);
                $total = $capc + $qde;
                if($total > $end[0]->capacity_qty){
                    //Capacidade Excedida
                    $erro = 3;
                }
                
            }
        }
        
        return $erro;
    }
    
}
