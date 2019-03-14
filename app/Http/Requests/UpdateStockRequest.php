<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Stock;
use Auth;

class UpdateStockRequest extends FormRequest
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
            'product_code' => 'required|string|exists:products,code,company_id,'.Auth::user()->company_id.'|max:40',
            'label_id' => 'nullable|integer|exists:labels,id,company_id,'.Auth::user()->company_id.'',
            'location_code' => 'required|string|exists:locations,code,company_id,'.Auth::user()->company_id.'|max:20',
            'qty' => 'required|numeric|between:0,9999999999.999999',
            'uom_code' => 'required|string|exists:uoms,code|max:6',
            'prim_qty' => 'required|numeric|between:0,9999999999.999999',
            'prim_uom_code' => 'required|string|exists:uoms,code|max:6',
            'pallet_id' => 'nullable|integer|exists:pallets,id,company_id,'.Auth::user()->company_id.'',
            'document_id' => 'nullable|integer|exists:documents,id,company_id,'.Auth::user()->company_id.'',
            'document_item_id' => 'nullable|digit|exists:document_items,id,company_id,'.Auth::user()->company_id.'',
            'task_id' => 'nullable|integer|exists:tasks,id,company_id,'.Auth::user()->company_id.'',
            'user_id' => 'nullable|integer|exists:users,id,company_id,'.Auth::user()->company_id.'',
            'operation_code' => 'required|string|exists:operations,code|max:30',
            'finality_code' => 'required|string|exists:finalities,code|max:10',
            'volume_id' => 'nullable|integer|exists:volumes,id,company_id,'.Auth::user()->company_id.'',
         ];
    }
}
