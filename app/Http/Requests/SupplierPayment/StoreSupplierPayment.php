<?php

namespace App\Http\Requests\SupplierPayment;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierPayment extends FormRequest
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
            'supplier_id' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'amount' => 'required|numeric|gt:0',
            'notes' => 'string|nullable',
        ];
    }
}
