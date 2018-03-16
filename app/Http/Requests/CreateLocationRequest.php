<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Location;
use Auth;

class CreateLocationRequest extends FormRequest
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
            'department_code' => 'required|string|exists:departments,code,company_id,'.Auth::user()->company_id.'|max:10',
            'deposit_code' => 'required|string|exists:deposits,code,company_id,'.Auth::user()->company_id.'|max:10',
            'sector_code' => 'required|string|exists:sectors,code,company_id,'.Auth::user()->company_id.'|max:10',
            'code' => 'required|string|unique:locations,code,NULL,id,company_id,'.Auth::user()->company_id.'|max:20',
            'barcode' => 'required|string|max:30',
            'location_type_code' => 'required|string|exists:location_types,code|max:10',
            'location_function_code' => 'required|string|exists:location_functions,code|max:10',
            'label_type_code' => 'required|string|exists:label_types,code|max:10',
            'stock_type_code' => 'required|integer|exists:stock_types,code',
            'aisle' => 'required|string|max:10',
            'column' => 'required|string|max:10',
            'status' => 'required|in:0,1',
            'depth' => 'nullable|numeric',
            'nivel' => 'nullable|numeric'
         ];
    }
}
