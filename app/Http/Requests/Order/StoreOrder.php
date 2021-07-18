<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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
            'customer_id' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'notes' => 'string|nullable',
            'orderItems' => 'required',
            'orderItems.*.item_id' => 'required',
            'orderItems.*.unit_id' => 'required',
            'orderItems.*.capacity' => 'required|numeric|gt:0',
            'orderItems.*.count' => 'required|numeric|gt:0',
            'orderItems.*.cost' => 'required|numeric|gt:0',
        ];
    }
}
