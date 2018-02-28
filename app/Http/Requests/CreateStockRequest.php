<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Stock;
use Auth;

class CreateStockRequest extends FormRequest
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
            'product_code' => 'required|string|exists:products,code,company_id,'.Auth::user()->company_id.'|max:40',
            'label_id' => 'sometimes|integer|exists:labels,id,company_id,'.Auth::user()->company_id.'',
         ];
    }
}
