<?php

namespace App\Models;

use Eloquent as Model;
use Auth;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PalletItem
 * @package App\Models
 * @version January 31, 2018, 3:52 pm BRST
 */
class PalletItem extends Model
{
    public $table = 'pallet_items';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'pallet_id',
        'product_code',
        'qty',
        'uom_code',
        'prev_qty',
        'prev_uom_code',
        'label_id',
        'activity_id',
        'pallet_status_id',
        'turn'
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
        'prev_uom_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
     //Retorna todos os itens de um palete
     public static function getPalletItems($pallet_id){
         
        return PalletItem::select('pallets.barcode as plt_barcode', 'labels.barcode as label_barcode',
                                  'pallet_items.product_code', 'pallet_items.prev_qty',
                                  'pallet_items.prev_uom_code', 'pallet_items.id')
                          ->join('pallets','pallets.id','pallet_items.pallet_id')
                          ->leftJoin('labels','labels.id','pallet_items.label_id')
                          ->where('pallet_items.company_id', Auth::user()->company_id)
                          ->where('pallet_items.pallet_id', $pallet_id)
                          ->where('pallet_items.pallet_status_id', '<>', '9')
                          ->get()
                          ->toArray();
    }

    /**
     * Função que deleta linhas com quantidades NEGATIVAS ou ZERADAS no palete
     * Parâmetros: ID do Palete e ID da empresa/filial
     * @var array
     */
    public static function cleanItems($pallet_id, $company_id = ''){
        $company_id = (trim($company_id == ''))?Auth::user()->company_id: $company_id;
        return PalletItem::where([ 
                                 ['company_id', $company_id],
                                 ['prev_qty', '<=', 0],
                                 ['pallet_id', $pallet_id]
                         ])
                         ->delete();

    }


}
