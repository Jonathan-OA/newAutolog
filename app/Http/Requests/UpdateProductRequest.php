<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use Auth;

class UpdateProductRequest extends FormRequest
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
            'code' => 'required|string|unique:products,code,'.$this->get('id').',id,company_id,'.Auth::user()->company_id.',customer_code,'.$this->get('customer_code').'|max:40',
            'description' => 'required|string|max:100',
            'status' => 'required|integer|in:0,1',
            'product_type_code' => 'required|exists:product_types,code',
            'group_code' => 'required|exists:groups,code',
            'subgroup_code' => 'nullable|exists:subgroups,code',
            'margin_div' => 'nullable|numeric',
            'customer_code' => 'nullable|string|exists:customers,code,company_id,'.Auth::user()->company_id.'|max:40',
            'cost' => 'nullable|numeric',
            'obs1' => 'nullable|string|max:40',
            'obs2' => 'nullable|string|max:40',
            'obs3' => 'nullable|string|max:40',
            'obs4' => 'nullable|string|max:40',
            'obs5' => 'nullable|string|max:40',
            ];
    }
}
