<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVolunteerRequest extends FormRequest
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
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:volunteers,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:volunteers,phone'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
            'occupation' => ['nullable', 'string', 'max:100'],
            'skills' => ['required', 'array', 'min:1'],
            'skills.*' => ['string', 'max:50'],
            'availability' => ['required', 'in:weekdays,weekends,flexible'],
            'profile_photo' => ['nullable', 'file', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'id_proof' => ['nullable', 'file', 'mimes:jpeg,png,webp,pdf', 'max:2048'],
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
            'skills.required' => 'Please select at least one skill or area of interest.',
            'skills.min' => 'Please select at least one skill or area of interest.',
            'email.unique' => 'A volunteer application with this email address has already been submitted.',
            'phone.unique' => 'A volunteer application with this phone number has already been submitted.',
            'profile_photo.max' => 'Profile photo may not be larger than 2MB.',
            'id_proof.max' => 'ID proof document may not be larger than 2MB.',
        ];
    }
}
