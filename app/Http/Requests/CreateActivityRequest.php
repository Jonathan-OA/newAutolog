<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Activity;
use Auth;

class CreateActivityRequest extends FormRequest
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
            'task_id' => 'required|integer|exists:tasks,id,company_id,'.Auth::user()->company_id.'',
            'user_id' => 'required|string|exists:users,id,company_id,'.Auth::user()->company_id.'',
            'document_id' => 'nullable|string|exists:documents,id,company_id,'.Auth::user()->company_id.'',
            'document_item_id' => 'nullable|integer|exists:document_items,id,company_id,'.Auth::user()->company_id.'',
            'label_id' => 'nullable|string|exists:labels,id,company_id,'.Auth::user()->company_id.'',
            'pallet_id' => 'nullable|string|exists:pallets,id,company_id,'.Auth::user()->company_id.'',
        ];
    }
}
