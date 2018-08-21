<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PalletItem;
use Auth;

class CreatePalletItemRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [ 
            'pallet_id' => 'required|integer|exists:pallets,id,company_id,'.Auth::user()->company_id,
            'product_code' => 'required|string|exists:products,code,company_id,'.Auth::user()->company_id.'|max:40',
            'label_id' => 'nullable|integer|exists:labels,id,company_id,'.Auth::user()->company_id.'',
            'qty' => 'required|numeric|between:0,9999999999.999999',
            'uom_code' => 'required|string|exists:uoms,code|max:6',
            'prev_qty' => 'required|numeric|between:0,9999999999.999999',
            'prev_uom_code' => 'required|string|exists:uoms,code|max:6',
            'pallet_status_id' => 'required|integer|exists:pallet_status,id',
            ];
    }
}
