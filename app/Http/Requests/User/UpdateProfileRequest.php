<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255',
            'full_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
