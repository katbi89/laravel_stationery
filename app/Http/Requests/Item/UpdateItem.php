<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItem extends FormRequest
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
            'name' => ['required', 'string', 'max:200', Rule::unique('items')->ignore($this->id)],
            'description' => 'string|nullable',
            'image' => 'image',
            'notes' => 'string|nullable',
            'units' => 'required',
            'units.*.name' => 'required|string',
            'units.*.capacity' => 'numeric|gt:0',
            'units.*.price' => 'numeric|gt:0',
        ];
    }
}
