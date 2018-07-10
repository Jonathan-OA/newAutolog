<?php

namespace App\Models;

use Eloquent as Model;
use Auth;
use DB;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Stock
 * @package App\Models
 * @version February 27, 2018, 12:10 pm BRT
 */
class Stock extends Model
{
    public $table = 'stocks';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'product_code',
        'label_id',
        'location_code',
        'qty',
        'uom_code',
        'prev_qty',
        'prev_uom_code',
        'pallet_id',
        'document_id',
        'document_item_id',
        'task_id',
        'finality_code',
        'user_id',
        'operation_code',
        'volume_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'product_code' => 'string',
        'location_code' => 'string',
        'uom_code' => 'string',
        'prev_uom_code' => 'string',
        'finality_code' => 'string',
        'user_id' => 'integer',
        'operation_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os saldos disponíveis
     public static function getStocks(){
        return Stock::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }

    /**
     * Função que insere / atualiza o saldo
     * Parâmetros: Array com informações a serem inseridas: Etiqueta, Quantidades, Unidades, Endereço,etc.
     * Retorna 0 quando faz insert e 1 quando faz update
     * @var array
     */
    public static function atuSaldo($input, $finalidade = "SALDO"){

        $input['company_id'] = Auth::user()->company_id;
        $input['finality_code'] = $finalidade;
        $input['user_id'] = Auth::user()->id;
        $input['operation_code'] = (empty($input['operation_code']))?'664':$input['operation_code'];

        //Caso seja reserva, empenho ou em inventário, coloca a quantidade negativa
        if($finalidade <> 'SALDO' && $finalidade <> 'RESSUP'){
            $input['qty'] *= -1;
            $input['prev_qty'] *= -1;
        }

        //Valida se existe a linha para decidir se faz insert ou update
        $valExist = DB::table('stocks')->select('id')
                         ->where([
                            ['company_id', $input['company_id']],
                            ['product_code', $input['product_code']],
                            ['label_id', $input['label_id']],
                            ['pallet_id', $input['pallet_id']],
                            ['location_code', $input['location_code']],
                            ['finality_code', $input['finality_code']],
                           ])
                         ->first();

        if(empty($valExist->id)){
            //Não existe, faz o insert
            $newStock = new Stock($input);
            $newStock->save();
            return 0;
        }else{
            //Existe, atualiza.
            $upStock = Stock::find($valExist->id);
            $upStock->qty = $upStock->qty + $input['qty'];
            $upStock->prev_qty = $upStock->prev_qty + $input['prev_qty'];
            $upStock->user_id = Auth::user()->id;
            $upStock->operation_code = $input['operation_code'];
            $upStock->save();
            return 1;
        }

    }

    /**
     * Função que retorna o total de saldo de um endereço
     * Parâmetros: Endereço e Produto
     * @var array
     */
    public static function getSaldo($endere, $produto = "", $company_id = ""){

        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        $GLOBALS['produto'] = $produto;
        //Obtem a soma do endereço
        $saldo = Stock::where([
                                ['company_id', $company_id],
                                ['location_code',$endere]
                       ])
                       ->where(function ($query) {
                           if(trim($GLOBALS['produto']) <> ''){
                                $query->where('product_code',$GLOBALS['produto']);
                           }
                       })
                      ->sum('prev_qty');
        return $saldo;         

    }

    /**
     * Função que retorna o saldo de um item por depósito (Para regras de liberação)
     * Parâmetros: Deposito(s), Produto e Tipo de Estoque (Palete, picking ou picking por produto)
     * @var array
     */
    public static function getSaldoDep($depositos, $produto, $tipoEstq = "", $company_id = ""){

        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;

        $GLOBALS['tipoEstq'] = $tipoEstq;
        $GLOBALS['depositos'] = explode(",",$depositos);
        
        //Obtem a soma do endereço
        $saldos = DB::table('stocks')->select('stocks.product_code', 'stocks.label_id','stocks.pallet_id',
                                              'stocks.location_code', DB::raw("SUM(prev_qty) as qty"),
                                              'stocks.uom_code')
                                     ->join('locations', function ($join) {
                                        $join->on('locations.code', '=', 'stocks.location_code')
                                             ->whereColumn('locations.company_id','stocks.company_id')
                                             ->whereIn('locations.deposit_code',$GLOBALS['depositos'])
                                             ->where('locations.status', 1)
                                             ->where(function ($query) {
                                                if(trim($GLOBALS['tipoEstq']) <> ''){
                                                     $query->where('locations.stock_type_code',$GLOBALS['tipoEstq']);
                                                }
                                             });
                                     })
                                     ->where([
                                                ['stocks.company_id', Auth::user()->company_id],
                                                ['stocks.product_code', $produto],
                                        ])
                                    ->groupBy('stocks.product_code', 'stocks.label_id','stocks.pallet_id',
                                              'stocks.location_code','stocks.uom_code')
                                    ->get()
                                    ->toArray();

                                    //FAZER FIFO (VALIDADE)
        return $saldos;         
    }


}
