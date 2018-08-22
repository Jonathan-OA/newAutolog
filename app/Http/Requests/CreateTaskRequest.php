<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task;
use Auth;

class CreateTaskRequest extends FormRequest
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
            'operation_code' => 'required|string|exists:operations,code',
            'task_status_id' => 'required|integer|exists:task_status,id',
            'document_id' => 'nullable|string|exists:documents,id,company_id,'.Auth::user()->company_id.'',
            'document_item_id' => 'nullable|integer|exists:document_items,id,company_id,'.Auth::user()->company_id.'',
            'orig_location_code' => 'nullable|string|exists:locations,code,company_id,'.Auth::user()->company_id.'',
            'dest_location_code' => 'nullable|string|exists:locations,code,company_id,'.Auth::user()->company_id.'',
        ];
    }
}
