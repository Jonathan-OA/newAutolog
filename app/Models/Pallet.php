<?php

namespace App\Models;

use Eloquent as Model;
use Auth;

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
        'packing_type_code'
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
        'packing_type_code' => 'string'
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

    public static function valPal( $barcode, $company_id = ''){

        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        $ret['erro'] = 0;

        //Valida prefixo do palete informado com o  parâmetro
        $pref = Parameter::getParam('prefixo_palete');               
        if(trim($pref) == ''){
            $pref = 'PLT';
        }

        if(strpos($pref,substr($barcode,0,3)) === false){
            //Prefixo de inválido
            $ret['erro'] = 3;
        }else{
            $pallet = Pallet::where([
                                    ['company_id', $company_id],
                                    ['barcode', $barcode]
                                    ])
                            ->get();

            if(count($pallet) == 0){
                //Palete não existe
                $ret['erro'] = 1;
            }else{
                //Status existe e esta encerrado ou cancelado.
                if($pallet[0]->pallet_status_id > 7){
                    $ret['erro'] = 2;
                }

                $ret['id'] = $pallet[0]->id;
            }
        }
        return $ret;

    }

    /**
     * Função que cria o palete com o barcode informado
     * Parâmetros: Barcode do palete, endereço, ID do documento e o ID da empresa / filial logada
     * @var array
     */

    public static function createPal( $barcode, $endere = 'REC', $document_id = NULL, $company_id = ''){
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


}
