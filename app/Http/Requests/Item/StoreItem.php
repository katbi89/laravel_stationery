<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class StoreItem extends FormRequest
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
            'name' => 'required|string|unique:items|max:200',
            'description' => 'string|nullable',
            'image' => 'image',
            'notes' => 'string|nullable',
            'units' => 'required',
            'units.*.name' => 'required|string',
            'units.*.capacity' => 'required|numeric|gt:0',
            'units.*.price' => 'required|numeric|gt:0',
        ];
    }
}
