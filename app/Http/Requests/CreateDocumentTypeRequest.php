<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\DocumentType;

class CreateDocumentTypeRequest extends FormRequest
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
            'code' => 'required|string|unique:document_types,code|max:5',
            'description' => 'required|string|max:50',
            'moviment_code' => 'required|string|exists:moviments,code|max:5',
            'label_type_code' => 'nullable|string|exists:label_types,code,company_id,'.Auth::user()->company_id.'|max:10',
            'operation_code' => 'nullable|string|exists:operations,code|max:30',
            ];
    }
}
