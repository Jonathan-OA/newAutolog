<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Auth;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|max:100',
            'code' => 'required|max:20|unique:users,code,'.$this->get('id').',id,company_id,'.Auth::user()->company_id,
            'email' => 'email|max:50',
            'password' => 'required|min:6|confirmed',
            'user_type_code' => 'required|max:10|exists:user_types,code',
            'status' => 'required|in:0,1',
        ];
    }
}
