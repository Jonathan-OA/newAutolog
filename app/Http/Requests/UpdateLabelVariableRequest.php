<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\LabelVariable;

class UpdateLabelVariableRequest extends FormRequest
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
            'code' => 'required|string|unique:label_variables,code,'.$this->get('id').',id|max:20',
            'description' => 'required|string|max:50',
            'table' => 'required|string|max:20',
            'field' => 'required|string|max:20',
            'size' => 'required|integer',
            'size_start' => 'required|integer'
            
        ];
    }
}
