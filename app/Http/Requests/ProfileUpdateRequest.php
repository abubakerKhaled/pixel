<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'handle' => ['required', 'string', 'max:255', 'min:3', 'unique:profiles,handle,'.$this->user()->profile->id],
            'bio' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'current_password'],
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
            'bio.string' => 'Bio must be a string.',
            'bio.max' => 'Bio cannot exceed 255 characters.',
            'password.required' => 'Password is required.',
            'password.current_password' => 'The password you entered is incorrect.',
        ];
    }
}
