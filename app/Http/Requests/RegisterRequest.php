<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            // 'phone_number' => 'nullable|regex:/^(\+234|0)[7|8|9][0-9]{1}[0-9]{6}$/',
            // 'phone_number' => ['nullable', 'regex:/^(\+234|0)[789][0-9]{8}$/'],
            // 'phone_number' => ['nullable', 'regex:/^(\+234|0)(7|8|9){1}(0|1){1}[0-9]{8}$/'],
            'phone_number' => ['nullable', 'regex:/^(\+234|0)[7-9][0-9]{9}$/'],
            'shipping_address' => 'nullable|string|max:500',
        ];
    }

}
