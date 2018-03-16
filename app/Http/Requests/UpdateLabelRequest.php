<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Label;

class UpdateLabelRequest extends FormRequest
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
            'company_id' => 'nullable|integer|exists:company_id,id,company_id,'.Auth::user()->company_id.'',
            'product_code' => 'required|string|exists:products,code,company_id,'.Auth::user()->company_id.'|max:40',
            'qty' => 'required|numeric|between:0,9999999999.999999',
            'uom_code' => 'required|string|exists:uoms,code|max:6',
            'prev_qty' => 'required|numeric|between:0,9999999999.999999',
            'prev_uom_code' => 'required|string|exists:uoms,code|max:6',
            'label_status_id' => 'required|digit|exists:label_status,id|max:2',
            ];
    }
}
