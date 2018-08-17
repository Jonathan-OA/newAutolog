<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Deposit;
use Auth;

class UpdateDepositRequest extends FormRequest
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
            'code' => 'required|string|unique:deposits,code,'.$this->get('id').',id,company_id,'.Auth::user()->company_id.'|max:10',
            'description' => 'required|string|max:50',
            'department_code' => 'required|string|exists:departments,code,company_id,'.Auth::user()->company_id.'|max:10',
            'deposit_type_code' => 'required|string|exists:deposit_types,code|max:10',
            'status' => 'required|in:0,1',
        ];
    }
}
