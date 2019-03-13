<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\LiberationRule;

class UpdateLiberationRuleRequest extends FormRequest
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
            'code' => 'required|max:10|unique:liberation_rules,code,'.$this->get('id').',id',
            'description' => 'required|string|max:100',
            'moviment_code' => 'required|string|max:5|exists:moviments,code',
        ];
    }
}
