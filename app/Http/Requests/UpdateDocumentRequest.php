<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Document;
use Auth;

class UpdateDocumentRequest extends FormRequest
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
            'number' => 'required|string|max:30',
            'company_id' => 'required|integer|exists:companies,id',
            'document_type_code' => 'required|string|exists:document_types,code|max:5',
            'document_status_id' => 'required|integer|exists:document_status,id',
            'user_id' => 'required|integer|exists:users,id,company_id,'.Auth::user()->company_id,
            'customer_code' => 'nullable|string|exists:customers,code,company_id,'.Auth::user()->company_id.'|max:40',
            'courier_code' => 'nullable|string|exists:couriers,code,company_id,'.Auth::user()->company_id.'|max:40',
            'supplier_code' => 'nullable|string|exists:suppliers,code,company_id,'.Auth::user()->company_id.'|max:40',
            ];
    }
}
