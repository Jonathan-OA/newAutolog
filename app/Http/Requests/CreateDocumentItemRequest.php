<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\DocumentItem;
use Auth;

class CreateDocumentItemRequest extends FormRequest
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
            'qty' => 'required|numeric|between:0,9999999999.999999',
            'uom_code' => 'required|string|exists:packings,uom_code,product_code,'.$this->get('product_code').'|max:6',
            'document_id' => 'required|integer|exists:documents,id,company_id,'.Auth::user()->company_id,
            'location_code' => 'nullable|string|exists:locations,code,company_id,'.Auth::user()->company_id.'',
            
            ];
    }
}
