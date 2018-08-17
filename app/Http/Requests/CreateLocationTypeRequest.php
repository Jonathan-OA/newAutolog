<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\LocationType;

class CreateLocationTypeRequest extends FormRequest
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
            'code' => 'required|string|unique:location_types,code|max:10',
            'description' => 'required|string|max:50',
            'capacity_kg' => 'nullable|numeric|between:0,9999999999.999999',
            'capacity_m3' => 'nullable|numeric|between:0,9999999999.999999',
            'capacity_qty' => 'nullable|numeric|between:0,9999999999.999999',
            'lenght' => 'nullable|numeric|between:0,9999999999.999999',
            'width' => 'nullable|numeric|between:0,9999999999.999999',
            'height' => 'nullable|numeric|between:0,9999999999.999999'
        ];
    }
}
