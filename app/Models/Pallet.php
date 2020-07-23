<?php

namespace App\Models;

use Eloquent as Model;
use Auth;
use Lang;
use DB;


use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Pallet
 * @package App\Models
 * @version January 17, 2018, 5:57 pm UTC
 */
class Pallet extends Model
{
    public $table = 'pallets';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'barcode',
        'pallet_status_id',
        'location_code',
        'document_id',
        'height',
        'stacking',
        'packing_type_code',
        'linked_document_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'barcode' => 'string',
        'location_code' => 'string',
        'packing_type_code' => 'string',
        'linked_document_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

     //Retorna todos os pallets disponíveis
     public static function getPallets(){
        return Pallet::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                     ->where('company_id', Auth::user()->company_id)
                     ->pluck('description_f','code');
    }

    /**
     * Função que valida o palete informado e retorna o erro / id 
     * Parâmetros: Barcode do palete e o ID da empresa / filial logada
     * @var array
     */

    public static function valPallet( $barcode, $company_id = ''){

        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        $ret['erro'] = 0;

        $barcode = strtoupper($barcode);

        //Valida prefixo do palete informado com o  parâmetro
        $pref = strtoupper(Parameter::getParam('prefixo_palete'));    
        if(trim($pref) == ''){
            $pref = 'PLT';
        }
        //Transforma parametro em array (casos de mais de um prefixo de palete)
        $prefArray = explode(',',$pref);  
        
        if(!in_array(substr($barcode,0,3),$prefArray)){
            //Prefixo de palete inválido
            $ret['erro'] = 3;
            $ret['msg_erro'] = \Lang::get('validation.plt_prefixo');
        }else{
            $pallet = Pallet::where([
                                    ['company_id', $company_id],
                                    ['barcode', $barcode]
                                    ])
                            ->get();

            if(count($pallet) == 0){
                //Palete não existe
                $ret['erro'] = 1;
                $ret['msg_erro'] = \Lang::get('validation.plt_not_exists');
            }else{
                //Palete existe e esta encerrado ou cancelado.
                if($pallet[0]->pallet_status_id == 8 || $pallet[0]->pallet_status_id == 9){
                    $ret['erro'] = 2;
                    $ret['msg_erro'] = \Lang::get('validation.plt_invalid');
                }else{
                    //Palete já existe no sistema - Valida se tem saldo
                    $stockPlt = Stock::where([
                                                    ['company_id', $company_id],
                                                    ['pallet_id', $pallet[0]->id],
                                                    ['finality_code', 'SALDO']
                                            ])
                                            ->get();
                    if(count($stockPlt) == 0){
                        //Sem saldo
                        $ret['erro'] = 4;
                        $ret['msg_erro'] = \Lang::get('validation.plt_stock');
                    }else{
                        //Com saldo
                        //Valida se possui etiquetas vencidas
                        if(PalletItem::valItems($pallet[0]->id) == 0){
                            $ret['erro'] = 5;
                            $ret['msg_erro'] = \Lang::get('validation.plt_exists');
                        }else{
                            $ret['erro'] = 6;
                            $ret['msg_erro'] = \Lang::get('validation.plt_dataval');
                        }
                    }
                   
                    
                }

                $ret['id'] = $pallet[0]->id;
                $ret['location'] = $pallet[0]->location_code;
            }
        }
        return $ret;

    }

    /**
     * Função que cria o palete com o barcode informado
     * Parâmetros: Barcode do palete, endereço, ID do documento e o ID da empresa / filial logada
     * @var array
     */

    public static function createPallet( $barcode, $endere = '', $document_id = NULL, $company_id = ''){
        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        $barcode = strtoupper($barcode);
        $ret['erro'] = 0;
        

        //Valida prefixo do palete informado com o  parâmetro
        $pref = Parameter::getParam('prefixo_palete');               
        if(trim($pref) == ''){
            $pref = 'PLT';
        }
        
        if(strpos($pref,substr($barcode,0,3)) === false){
            //Não tem prefixo de palete
            $ret['erro'] = 1;
            $ret['id'] = null;
        }else{
            $pallet = Pallet::where([
                                    ['company_id', $company_id],
                                    ['barcode', $barcode],   
                                    ['pallet_status_id', '<>', 9]
                                    ])
                            ->get();
            //Valida se barcode não existe
            if(count($pallet) == 0){
                $newPlt = new Pallet();
                $newPlt->company_id =  $company_id;
                $newPlt->barcode =  $barcode;
                $newPlt->pallet_status_id = 0;
                $newPlt->location_code = $endere;
                $newPlt->document_id = $document_id;
                $newPlt->save();

                $ret['id'] = $newPlt->id;
            }else{
                //Retorna null caso seja um Palete inválido
                $ret['erro'] = 2;
                $ret['id'] = null;
            }
        }

        return $ret;
    }

    /**
     * Função que insere / atualiza o saldo no palete
     * Parâmetros: Array com informações a serem inseridas: Etiqueta, Quantidades, Unidades,etc.
     * Retorna 0 quando faz insert e 1 quando faz update
     * @var array
     */
    public static function updPallet($input){
        //Valida se existe a linha para a etiqueta / produto
        $valExist = DB::table('pallet_items')->select('id')
                        ->where([
                                    ['company_id', $input['company_id']],
                                    ['pallet_id', $input['pallet_id']],
                                    ['label_id', $input['label_id']],
                                    ['pallet_status_id', '<>', '9']
                        ])
                        ->first();

        if(empty($valExist->id)){
            //Não existe, faz o insert
            $input['pallet_status_id'] = 2;
            $newItem = new PalletItem($input);
            $newItem->save();
        }else{
            //Existe, atualiza
            $upItem = PalletItem::find($valExist->id);
            $upItem->prim_qty = $upItem->prim_qty + $input['prim_qty'];
            //-----------------------------------------------------------------------------------------
            //Validações para quantidade e quantidade primária ficarem corretas
            //Só mexe na quantidade principal caso val_integer seja ativo (só aceita números inteiros)
            $levels = Packing::getLevels($upItem->product_code);
            if($upItem->uom_code <> $input['uom_code'] && $levels[$input['uom_code']]['int'] == 1){
                if($levels[$upItem->uom_code]['level'] < $levels[$input['uom_code']]['level']){
                    //Nível de embalagem que já existe na saldo é menor que o novo (Ex: UN - CX)
                    //Soma a quantidade anterior do nível maior
                    $upItem->qty += $input['prev_qty'];
                }else{
                    //Nível de embalagem que já existe na saldo é maior que o novo (Ex: CX - UN)
                    //Só incrementa caso a quantidade atual + nova ultrapasse prim_qty
                    $prevQtyLevel = $levels[$upItem->uom_code]['prev_qty'];
                    $upItem->qty  = ceil($upItem->prim_qty/$prevQtyLevel);
                }
            }else if($levels[$input['uom_code']]['int'] == 1){
                //Mesma unidade e só aceita números inteiros, só incrementa
                $upItem->qty = $upItem->qty + $input['qty'];
                //Se nível principal > anterior, ajusta quantidade
                $prevQtyLevel = $levels[$upItem->uom_code]['prev_qty'];
                if($levels[$input['uom_code']]['level'] > $levels[$input['prim_uom_code']]['level']){
                    $upItem->qty = ceil($upItem->prim_qty/$prevQtyLevel);
                }
                
            }
            //------------------------------------------------------------------------------------------
            $upItem->save();
        }

        //Apaga linhas negativas
        $clPlt = PalletItem::cleanItems($input['pallet_id']);

        return true;
    }



}
