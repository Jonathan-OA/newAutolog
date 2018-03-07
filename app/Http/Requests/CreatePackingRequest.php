<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Packing;

class CreatePackingRequest extends FormRequest
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
            'barcode' => 'required|string|unique:labels,barcode,NULL,id,company_id,'.Auth::user()->company_id.'|max:40',
            'company_id' => 'required|integer|exists:company_id,id,company_id,'.Auth::user()->company_id.'',
            'product_code' => 'required|string|exists:products,code,company_id,'.Auth::user()->company_id.'|max:40',
            'uom_code' => 'required|string|exists:uoms,code|max:6',
            'prev_qty' => 'required|numeric|between:0,9999999999.999999',
            'label_type_code' => 'nullable|string|exists:label_types,code|max:10',
            'print_label' => 'required|digits:1',
            'create_label' => 'required|digits:1',
            'conf_batch' => 'required|digits:1',
            'conf_due_date' => 'required|digits:1',
            'conf_prod_date' => 'required|digits:1',

            ];
    }
}
