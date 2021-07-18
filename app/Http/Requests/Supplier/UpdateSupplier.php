<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplier extends FormRequest
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
            'company' => ['required', 'string', 'max:200', Rule::unique('suppliers')->ignore($this->id)],
            'name' => 'string|nullable|max:200',
            'phone' => 'numeric|nullable',
            'mobile' => 'numeric|nullable',
            'address' => 'string|nullable',
            'notes' => 'string|nullable',
        ];
    }
}
