<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Volume;
use Auth;

class CreateVolumeRequest extends FormRequest
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
            'barcode' => 'required|string|unique:products,code,NULL,id,company_id,'.Auth::user()->company_id.'|max:45',
            'volume_status_id' => 'required|integer|exists:volume_status,id',
            'location_code' => 'nullable|string|exists:locations,code,company_id,'.Auth::user()->company_id.'',
            'document_id' => 'nullable|integer|exists:documents,id,company_id,'.Auth::user()->company_id.'',
            'packing_type_code' => 'nullable|exists:packing_types,code',
            ];
    }
}
