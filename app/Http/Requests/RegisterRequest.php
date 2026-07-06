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
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'handle' => ['required', 'string', 'max:255', 'min:3', 'unique:profiles,handle'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'max:255', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'max:255', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'name.min' => 'Name must be at least 3 characters.',
            'handle.required' => 'Handle is required.',
            'handle.string' => 'Handle must be a string.',
            'handle.max' => 'Handle cannot exceed 255 characters.',
            'handle.min' => 'Handle must be at least 3 characters.',
            'handle.unique' => 'Handle already taken.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email cannot exceed 255 characters.',
            'email.unique' => 'Email already taken.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.max' => 'Password cannot exceed 255 characters.',
            'password.min' => 'Password must be at least 8 characters.',
            'password_confirmation.required' => 'Password confirmation is required.',
            'password_confirmation.string' => 'Password confirmation must be a string.',
            'password_confirmation.max' => 'Password confirmation cannot exceed 255 characters.',
            'password_confirmation.min' => 'Password confirmation must be at least 8 characters.',
        ];
    }
}
