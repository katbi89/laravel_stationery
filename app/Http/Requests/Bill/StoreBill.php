<?php

namespace App\Http\Requests\Bill;

use Illuminate\Foundation\Http\FormRequest;

class StoreBill extends FormRequest
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
            'supplier_id' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'order_id' => 'string|nullable',
            'notes' => 'string|nullable',
            'order_id' => 'required|max:10',
            'billItems' => 'required',
            'billItems.*.item_id' => 'required',
            'billItems.*.unit_id' => 'required',
            'billItems.*.capacity' => 'required|numeric|gt:0',
            'billItems.*.count' => 'required|numeric|gt:0',
            'billItems.*.cost' => 'required|numeric|gt:0',
        ];
    }
}
