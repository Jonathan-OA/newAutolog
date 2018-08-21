<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Pallet;
use Auth;

class CreatePalletRequest extends FormRequest
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
            'barcode' => 'required|string|max:45',
            'pallet_status_id' => 'required|integer|exists:pallet_status,id',
            'location_code' => 'nullable|string|exists:locations,code,company_id,'.Auth::user()->company_id.'',
            'document_id' => 'nullable|integer|exists:documents,id,company_id,'.Auth::user()->company_id.'',
            'linked_document_id' => 'nullable|integer|exists:documents,id,company_id,'.Auth::user()->company_id.'',
            'packing_type_code' => 'nullable|exists:packing_types,code',
            ];
    }
}
