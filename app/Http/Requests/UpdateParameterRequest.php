<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Parameter;
use Auth;

class UpdateParameterRequest extends FormRequest
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
            'code' => 'required|string|max:25|unique:parameters,code,'.$this->get('id').',id,company_id,'.Auth::user()->company_id.'',
            'operation_code' => 'required|exists:operations,code',
            'description' => 'required|string|max:50',
            'value' => 'required|string|max:100',
        ];
    }
}
