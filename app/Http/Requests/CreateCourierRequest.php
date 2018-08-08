<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Courier;
use Auth;

class CreateCourierRequest extends FormRequest
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
            'code' => 'required|string|unique:couriers,code,NULL,id,company_id,'.Auth::user()->company_id.'|max:40',
            'name' => 'required|string|max:50',
            'trading_name' => 'required|string|max:60',
            'state_registration' => 'nullable|string|max:20',
            'cnpj' => 'nullable|string|max:20',
            'status' => 'required|in:0,1',
         ];
    }
}
