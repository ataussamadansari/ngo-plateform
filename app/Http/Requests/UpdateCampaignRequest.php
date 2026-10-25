<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateCampaignRequest extends FormRequest
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
            'slug' => $this->slug ? Str::slug($this->slug) : Str::slug($this->title),
            'is_featured' => $this->boolean('is_featured'),
            'is_urgent' => $this->boolean('is_urgent'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $campaign = $this->route('campaign');
        $campaignId = is_object($campaign) ? $campaign->id : $campaign;

        return [
            'category_id' => ['required', 'exists:cause_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('campaigns', 'slug')->ignore($campaignId)],
            'short_description' => ['required', 'string', 'max:500'],
            'full_story' => ['required', 'string'],
            'thumbnail_image' => ['nullable', 'file', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'gallery_images' => ['nullable', 'array', 'max:8'],
            'gallery_images.*' => ['file', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'goal_amount' => ['required', 'numeric', 'min:100', 'max:99999999.99'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_featured' => ['nullable', 'boolean'],
            'is_urgent' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,active,completed,paused'],
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
            'thumbnail_image.max' => 'The thumbnail image must not exceed 2MB.',
            'thumbnail_image.mimes' => 'The thumbnail must be an image of type: JPEG, PNG, or WEBP.',
            'gallery_images.max' => 'You can upload up to 8 story gallery photos.',
            'gallery_images.*.max' => 'Each gallery photo must not exceed 2MB.',
            'goal_amount.min' => 'Campaign goal amount must be at least ₹100.',
        ];
    }
}
