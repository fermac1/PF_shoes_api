<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'string|required',
            'description' => 'required',
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0.01', 'max:10000'],
            'quantity' => 'required|numeric'
        ];
    }
}
