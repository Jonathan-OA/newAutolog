<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\DepositType;
use Request;

class UpdateDepositTypeRequest extends FormRequest
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
            'code' => 'required|string|unique:deposit_types,code,'.$this->get('id').',id|max:10',
            'description' => 'required|string|max:50'
        ];
    }
}
