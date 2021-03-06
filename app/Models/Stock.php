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
        'prim_qty',
        'prim_uom_code',
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
        'prim_uom_code' => 'string',
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
        if($finalidade <> 'SALDO' && $finalidade <> 'RESSUP' && $input['qty'] > 0){
            $input['qty'] *= -1;
            $input['prim_qty'] *= -1;
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
            $upStock->prim_qty = $upStock->prim_qty + $input['prim_qty'];
            //-----------------------------------------------------------------------------------------
            //Validações para quantidade e quantidade primária ficarem corretas
            //Só mexe na quantidade principal caso val_integer seja ativo (só aceita números inteiros)
            $levels = Packing::getLevels($upStock->product_code); //Pega todas embalagens
            if($upStock->uom_code <> $input['uom_code'] && $levels[$input['uom_code']]['int'] == 1){
                if($levels[$upStock->uom_code]['level'] < $levels[$input['uom_code']]['level']){
                    //Nível de embalagem que já existe na saldo é menor que o novo (Ex: UN - CX)
                    //Soma a quantidade anterior do nível maior
                    $upStock->qty += $input['prim_qty'];
                }else{
                    //Nível de embalagem que já existe na saldo é maior que o novo (Ex: CX - UN)
                    //Só incrementa caso a quantidade atual + nova ultrapasse prim_qty
                    $prevQtyLevel = $levels[$upStock->uom_code]['prim_qty'];
                    $upStock->qty  = ceil($upStock->prim_qty/$prevQtyLevel);
                }
            }else if($levels[$input['uom_code']]['int'] == 1){
                //Mesma unidade e só aceita números inteiros, só incrementa
                $upStock->qty = $upStock->qty + $input['qty'];
                //Se nível principal > anterior, ajusta quantidade
                $prevQtyLevel = $levels[$upStock->uom_code]['prim_qty'];
                if($levels[$input['uom_code']]['level'] > $levels[$input['prim_uom_code']]['level']){
                    $upStock->qty = ceil($upStock->prim_qty/$prevQtyLevel);
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
    public static function getStock($location_code, $product_code = "", $type=1, $company_id = ""){

        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        $GLOBALS['produto'] = $product_code;

        //Se $type == 1, retorna a somatória total. Se == 2, retorna as linhas detalhadas referentes ao item
        if($type == 1){
            //Obtem a soma do endereço
            $saldo = Stock::where([
                                    ['company_id', $company_id],
                                    ['location_code',$location_code]
                        ])
                        ->where(function ($query) {
                            if(trim($GLOBALS['produto']) <> ''){
                                    $query->where('product_code',$GLOBALS['produto']);
                            }
                        })
                        ->sum('prim_qty');
        }else{
            //Pega todas as infos
            $saldo = Stock::where([
                                    ['company_id', $company_id],
                                    ['location_code',$location_code]
                                ])
                                ->where(function ($query) {
                                    if(trim($GLOBALS['produto']) <> ''){
                                            $query->where('product_code',$GLOBALS['produto']);
                                    }
                                })
                                ->get()
                                ->toArray();
        }
        return $saldo;         


    }

    /**
     * Função que retorna o saldo de um item por depósito (Para regras de liberação)
     * Parâmetros: Deposito(s), Produto e Tipo de Estoque (Palete, picking ou picking por produto)
     * @var array
     */
    public static function getStockDep($depositos, $product_code, $tipoEstq = "", $company_id = ""){

        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;

        $GLOBALS['tipoEstq'] = $tipoEstq;
        //Transforma os depositos em array retirando os espaços em branco
        $GLOBALS['depositos'] = explode(",",substr(str_replace(' ','',$depositos),0,-1));
        
        //Obtem a soma do endereço
        $saldos = DB::table('stocks')->select('stocks.product_code', 'stocks.label_id','stocks.pallet_id',
                                              'stocks.location_code', DB::raw("SUM(prim_qty) as qty"),
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
                                                ['stocks.product_code', $product_code],
                                        ])
                                    ->groupBy('stocks.product_code', 'stocks.label_id','stocks.pallet_id',
                                              'stocks.location_code','stocks.uom_code')
                                    ->get()
                                    ->toArray();

                                    //FAZER FIFO (VALIDADE)
        return $saldos;         
    }

    /**
     * Função que retorna os saldos disponíveis (Para Inventário)
     * Parâmetros: Deposito(s) e ID do Documento de Inventário
     * @var array
     */
    public static function getStockInv($depositos, $document_id, $company_id = ""){

        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        
        //Transforma os depositos em array retirando os espaços em branco
        $GLOBALS['depositos'] = explode(",",substr(str_replace(' ','',$depositos),0,-1));
        $GLOBALS['document_id'] = $document_id;


        //Obtem os endereços / produtos
        $saldos = DB::table('stocks')->select('locations.deposit_code', 
                                              'stocks.location_code',
                                              'stocks.product_code',
                                              DB::raw("SUM(stocks.prim_qty) as qde"),
                                              'stocks.prim_uom_code',
                                              DB::raw("COUNT(others.id) as count"),
                                              DB::raw("COUNT(inventory_items.id) as exs"))
                                     ->join('locations', function ($join) {
                                         //Considera apenas os depositos do filtro
                                        $join->on('locations.code', '=', 'stocks.location_code')
                                             ->whereColumn('locations.company_id','stocks.company_id')
                                             ->whereIn('locations.deposit_code',$GLOBALS['depositos']);
                                     })
                                     ->leftJoin('inventory_items', function ($join) {
                                         //Desconsidera itens já inseridos no documento
                                        $join->on('stocks.location_code', '=', 'inventory_items.location_code')
                                             ->whereColumn('stocks.company_id','inventory_items.company_id')
                                             ->whereColumn('stocks.product_code','inventory_items.product_code')
                                             ->where('inventory_items.document_id', $GLOBALS['document_id']);
                                     })
                                     ->leftJoin('stocks as others', function ($join) {
                                        //Conta se o endereço/produto possui reserva / empenho / inventário
                                       $join->on('stocks.location_code', '=', 'others.location_code')
                                            ->whereColumn('stocks.company_id','others.company_id')
                                            ->whereColumn('stocks.product_code','others.product_code')
                                            ->where('others.finality_code','<>', 'SALDO');
                                    })
                                     ->where([
                                        ['stocks.company_id', Auth::user()->company_id],
                                        ['stocks.finality_code', 'SALDO']
                                     ])
                                     ->groupBy('locations.deposit_code', 
                                               'stocks.location_code',
                                               'stocks.product_code',
                                               'stocks.prim_uom_code')
                                     ->orderBy('locations.deposit_code')
                                     ->get()
                                     ->toArray();

        return $saldos;         
    }

    /**
     * Função que valida se existe um saldo de acordo com os parâmetros
     * Parâmetros: Endereço e Produto
     * @var array
     */
    public static function verStock($pallet_id, $location_code, $label_id, $produto, $company_id = ""){
        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;

        $GLOBALS['pallet_id'] = $pallet_id;
        $GLOBALS['company_id'] = $company_id;
        $GLOBALS['location_code'] = $location_code;
        $GLOBALS['label_id'] = $label_id;

        $saldo = Stock::where(function ($query) {
                            $query->where('company_id',$GLOBALS['company_id']);
                            $query->where('finality_code','SALDO');

                            if(trim($GLOBALS['pallet_id']) <> ''){
                                $query->where('pallet_id',$GLOBALS['pallet_id']);
                            }
                            if(trim($GLOBALS['location_code']) <> ''){
                                $query->where('location_code',$GLOBALS['location_code']);
                            }
                            if(trim($GLOBALS['label_id']) <> ''){
                                $query->where('label_id',$GLOBALS['label_id']);
                            }
                        })
                       ->count();
        return $saldo;

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
                                 ['prim_qty', '<=', 0],
                                 ['product_code', $product_code],
                                 ['location_code', $location_code],
                                 ['finality_code', 'SALDO']
                         ])
                         ->delete();

    }


}
