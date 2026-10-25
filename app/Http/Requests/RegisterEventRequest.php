<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterEventRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'participant_name' => ['required', 'string', 'max:150'],
            'participant_phone' => ['required', 'string', 'max:20'],
            'participant_email' => ['nullable', 'email', 'max:150'],
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'participant_name.required' => 'Please provide your full name for registration.',
            'participant_phone.required' => 'Please provide your phone number so we can confirm your spot.',
        ];
    }
}
