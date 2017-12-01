<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Customer;

class CreateCustomerRequest extends FormRequest
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
            'code' => 'required|string|unique:customers,code,NULL,id,company_id,'.Auth::user()->company_id.'|max:30',
            'name' => 'required|string|max:50',
            'trading_name' => 'required|string|max:60',
            'state_registration' => 'string|max:20',
            'cnpj' => 'string|max:20',
            'active' => 'required|in:0,1',
         ];
    }
}
