<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
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
            'utr_number' => $this->utr_number ? trim($this->utr_number) : null,
            'donor_phone' => $this->donor_phone ? trim($this->donor_phone) : null,
            'donor_pan' => $this->donor_pan ? strtoupper(trim($this->donor_pan)) : null,
            'is_anonymous' => $this->boolean('is_anonymous'),
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
            'donor_name' => ['required', 'string', 'max:255'],
            'donor_email' => ['required', 'email', 'max:255'],
            'donor_phone' => ['required', 'string', 'regex:/^[0-9+ -]{10,20}$/'],
            'donor_pan' => ['nullable', 'string', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i'],
            'donor_address' => ['nullable', 'string', 'max:500'],
            'amount' => ['required', 'numeric', 'min:1', 'max:10000000'],
            'payment_mode' => ['required', 'in:upi_qr,bank_transfer'],
            'utr_number' => ['required', 'string', 'min:6', 'max:30', 'unique:donations,utr_number'],
            'payment_screenshot' => ['required', 'file', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'campaign_id' => ['nullable', 'exists:campaigns,id'],
            'donor_message' => ['nullable', 'string', 'max:1000'],
            'is_anonymous' => ['nullable', 'boolean'],
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
            'utr_number.unique' => 'This UTR / Reference number has already been submitted. Please check your donation status.',
            'utr_number.required' => 'Please provide the transaction UTR / Reference number.',
            'payment_screenshot.max' => 'The payment screenshot must not be larger than 2MB.',
            'payment_screenshot.mimes' => 'The payment screenshot must be an image of type: JPEG, PNG, or WEBP.',
            'donor_pan.regex' => 'The PAN number must follow the format (e.g. ABCDE1234F).',
            'amount.min' => 'Donation amount must be at least ₹1.',
        ];
    }
}
