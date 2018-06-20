<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\BlockedGroup;
use Auth;

class CreateBlockedGroupRequest extends FormRequest
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
            'deposit_code' => 'required|string|exists:deposits,code,company_id,'.Auth::user()->company_id.'|max:10',
            'sector_code' => 'required|string|exists:sectors,code,company_id,'.Auth::user()->company_id.'|max:10',
            'group_code' => 'required|string|exists:groups,code,company_id,'.Auth::user()->company_id.'|max:20',
        ];
    }
}
