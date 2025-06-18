<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'bio' => ['nullable', 'string', 'max:500'],
            'contact' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'profile_picture' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ];
    }

    public function messages(): array
    {
        return [
            'contact.regex' => 'Please enter a valid number',
        ];
    }
}
