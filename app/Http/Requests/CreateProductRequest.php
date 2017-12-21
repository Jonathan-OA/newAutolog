<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use Auth;

class CreateProductRequest extends FormRequest
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
                'code' => 'required|string|unique:products,code,NULL,id,company_id,'.Auth::user()->company_id.'|max:40',
                'description' => 'required|string|max:100',
                'status' => 'required|digits:1|in:0,1',
                'product_type_code' => 'required|exists:product_types,code',
                'group_code' => 'required|exists:groups,code',
                'margin_div' => 'numeric',
                'cost' => 'numeric',
                'obs1' => 'string|max:40',
                'obs2' => 'string|max:40',
                'obs3' => 'string|max:40',
                'obs4' => 'string|max:40',
                'obs5' => 'string|max:40',
                ];
    }
}
