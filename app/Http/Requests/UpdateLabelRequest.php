<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Label;
use Auth;
use Request;

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
            'barcode' => 'required|string|unique:labels,barcode,'.$this->get('id').',id,company_id,'.Auth::user()->company_id.'|max:40',
            'company_id' => 'required|integer|exists:companies,id',
            'product_code' => 'required|string|exists:products,code,company_id,'.Auth::user()->company_id.'|max:40',
            'qty' => 'required|numeric|between:0,9999999999.999999',
            'uom_code' => 'required|string|exists:uoms,code|max:6',
            'prev_qty' => 'required|numeric|between:0,9999999999.999999',
            'prev_uom_code' => 'required|string|exists:uoms,code|max:6',
            'label_status_id' => 'required|integer|exists:label_status,id',
            'label_type_code' => 'required|string|exists:label_types,code,company_id,'.Auth::user()->company_id.'|max:10',
            'document_id' => 'nullable|integer|exists:documents,id,company_id,'.Auth::user()->company_id,
            'document_item_id' => 'nullable|integer|exists:document_items,id,company_id,'.Auth::user()->company_id,
            'task_id' => 'nullable|integer|exists:tasks,id,company_id,'.Auth::user()->company_id,
            'origin' => 'nullable|integer|exists:labels,id,company_id,'.Auth::user()->company_id
            ];
    }
}
