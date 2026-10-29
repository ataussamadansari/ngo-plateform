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
     * Prepare inputs prior to validation.
     */
    protected function prepareForValidation(): void
    {
        if (! $this->has('skills') && $this->filled('area_of_interest')) {
            $this->merge([
                'skills' => [$this->input('area_of_interest')],
            ]);
        }

        if (! $this->has('city') || empty($this->input('city'))) {
            $this->merge([
                'city' => 'Varanasi',
            ]);
        }
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
            'date_of_birth' => ['nullable'],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
            'occupation' => ['nullable', 'string', 'max:100'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['string', 'max:100'],
            'area_of_interest' => ['nullable', 'string', 'max:150'],
            'about_yourself' => ['nullable', 'string', 'max:2000'],
            'about_volunteer' => ['nullable', 'string', 'max:2000'],
            'availability' => ['required', 'string'],
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
            'full_name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.unique' => 'A volunteer application with this email address has already been submitted.',
            'phone.required' => 'Please enter your mobile phone number.',
            'phone.unique' => 'A volunteer application with this phone number has already been submitted.',
            'availability.required' => 'Please select your availability preference.',
            'profile_photo.max' => 'Profile photo may not be larger than 2MB.',
            'id_proof.max' => 'ID proof document may not be larger than 2MB.',
        ];
    }
}
