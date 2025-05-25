<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'product_name' => 'string|required',
            'description' => 'required',
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0.01', 'max:10000'],
            'quantity' => 'required|numeric'
        ];
    }
}
