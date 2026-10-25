<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
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
        $eventId = $this->route('event')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('events', 'slug')->ignore($eventId)],
            'description' => ['required', 'string'],
            'banner_image' => ['nullable', 'file', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'location_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'google_map_link' => ['nullable', 'url', 'max:500'],
            'event_date' => ['required', 'date'],
            'start_time' => ['required', 'string'],
            'end_time' => ['nullable', 'string'],
            'max_participants' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'in:upcoming,ongoing,completed,cancelled'],
        ];
    }
}
