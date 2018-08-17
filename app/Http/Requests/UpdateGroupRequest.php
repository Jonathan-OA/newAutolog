<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Group;
use Auth;

class UpdateGroupRequest extends FormRequest
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
            'code' => 'required|string|unique:groups,code,'.$this->get('id').',id,company_id,'.Auth::user()->company_id.'|max:10',
            'description' => 'required|string|max:50',
            'product_type_code' => 'required|exists:product_types,code',
        ];
    }
}
