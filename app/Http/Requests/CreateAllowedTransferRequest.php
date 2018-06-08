<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\AllowedTransfer;
use Auth;

class CreateAllowedTransferRequest extends FormRequest
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
            'orig_department_code' => 'required|string|exists:departments,code,company_id,'.Auth::user()->company_id,
            'orig_deposit_code' => 'required|string|exists:deposits,code,company_id,'.Auth::user()->company_id,
            'dest_department_code' => 'required|string|exists:departments,code,company_id,'.Auth::user()->company_id,
            'dest_deposit_code' => 'required|string|exists:deposits,code,company_id,'.Auth::user()->company_id,
            'operation_code' => 'required|string',
            'document_type_code' => 'required|string|exists:document_types,code',
            ];
    }
}
