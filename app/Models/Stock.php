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
    public static function updStock($input, $finalidade = "SALDO"){

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

            //Se tem palete, atualiza pallet_itens
            if(!empty($input['pallet_id']) && $input['pallet_id'] > 0){
                $resPlt = Pallet::updPallet($input);
            }
           
        }else{
            //Existe, atualiza.
            $upStock = Stock::find($valExist->id);
            $upStock->prev_qty = $upStock->prev_qty + $input['prev_qty'];
            //-----------------------------------------------------------------------------------------
            //Validações para quantidade e quantidade primária ficarem corretas
            //Só mexe na quantidade principal caso val_integer seja ativo (só aceita números inteiros)
            $levels = Packing::getLevels($upStock->product_code);
            if($upStock->uom_code <> $input['uom_code'] && $levels[$input['uom_code']]['int'] == 1){
                if($levels[$upStock->uom_code]['level'] < $levels[$input['uom_code']]['level']){
                    //Nível de embalagem que já existe na saldo é menor que o novo (Ex: UN - CX)
                    //Soma a quantidade anterior do nível maior
                    $upStock->qty += $input['prev_qty'];
                }else{
                    //Nível de embalagem que já existe na saldo é maior que o novo (Ex: CX - UN)
                    //Só incrementa caso a quantidade atual + nova ultrapasse prev_qty
                    $prevQtyLevel = $levels[$upStock->uom_code]['prev_qty'];
                    $upStock->qty  = ceil($upStock->prev_qty/$prevQtyLevel);
                }
            }else if($levels[$input['uom_code']]['int'] == 1){
                //Mesma unidade e só aceita números inteiros, só incrementa
                $upStock->qty = $upStock->qty + $input['qty'];
                //Se nível principal > anterior, ajusta quantidade
                $prevQtyLevel = $levels[$upStock->uom_code]['prev_qty'];
                if($levels[$input['uom_code']]['level'] > $levels[$input['prev_uom_code']]['level']){
                    $upStock->qty = ceil($upStock->prev_qty/$prevQtyLevel);
                }
                
            }
            //------------------------------------------------------------------------------------------
            
            $upStock->user_id = Auth::user()->id;
            $upStock->operation_code = $input['operation_code'];
            $upStock->save();

            //Se tem palete, atualiza pallet_itens
            if(!empty($input['pallet_id']) && $input['pallet_id'] > 0){
                $resPlt = Pallet::updPallet($input);
            }

            
        }

        //Apaga linhas negativas / zeradas
        $clStock = Stock::cleanStock($input['location_code'], $input['product_code']);

        return true;

    }

    /**
     * Função que retorna o total de saldo de um endereço
     * Parâmetros: Endereço e Produto
     * @var array
     */
    public static function getStock($endere, $produto = "", $company_id = ""){

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
    public static function getStockDep($depositos, $produto, $tipoEstq = "", $company_id = ""){

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

    /**
     * Função que deleta linhas com quantidades NEGATIVAS ou ZERADAS na saldo
     * Parâmetros: Código do endereço, código do produto e ID da empresa/filial
     * @var array
     */
    public static function cleanStock($location_code, $product_code, $company_id = ''){
        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        return Stock::where([ 
                                 ['company_id', $company_id],
                                 ['prev_qty', '<=', 0],
                                 ['product_code', $product_code],
                                 ['location_code', $location_code],
                                 ['finality_code', 'SALDO']
                         ])
                         ->delete();

    }


}
