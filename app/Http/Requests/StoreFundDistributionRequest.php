<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFundDistributionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => $this->title ? trim($this->title) : null,
            'beneficiary_name' => $this->beneficiary_name ? trim($this->beneficiary_name) : null,
            'payment_reference' => $this->payment_reference ? trim($this->payment_reference) : null,
            'is_public' => $this->has('is_public') ? $this->boolean('is_public') : true,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'beneficiary_name' => ['required', 'string', 'max:200'],
            'amount_spent' => ['required', 'numeric', 'min:1', 'max:99999999.99'],
            'distribution_date' => ['required', 'date', 'before_or_equal:today'],
            'campaign_id' => ['nullable', 'exists:campaigns,id'],
            'payment_reference' => ['nullable', 'string', 'max:150'],
            'proof_bill_image' => ['nullable', 'file', 'mimes:jpeg,png,webp,pdf', 'max:2048'],
            'impact_photos' => ['nullable', 'array', 'max:6'],
            'impact_photos.*' => ['file', 'mimes:jpeg,png,webp', 'max:2048'],
            'description' => ['required', 'string', 'max:3000'],
            'is_public' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'amount_spent.min' => 'Amount spent must be at least ₹1.00.',
            'distribution_date.before_or_equal' => 'Distribution date cannot be in the future.',
            'proof_bill_image.max' => 'The bill/invoice document must not be larger than 2MB.',
            'proof_bill_image.mimes' => 'The bill/invoice document must be a file of type: JPEG, PNG, WEBP, or PDF.',
            'impact_photos.max' => 'You can upload up to 6 impact photos.',
            'impact_photos.*.max' => 'Each impact photo must not be larger than 2MB.',
            'impact_photos.*.mimes' => 'Impact photos must be images of type: JPEG, PNG, or WEBP.',
        ];
    }
}
