<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Department;
use Auth;

class CreateDepartmentRequest extends FormRequest
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
            'code' => 'required|string|unique:departments,code,NULL,id,company_id,'.Auth::user()->company_id.'|max:10',
            'description' => 'required|string|max:50',
            'status' => 'required|in:0,1',
        ];
    }
}
