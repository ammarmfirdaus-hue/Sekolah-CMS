<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentationEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_published' => ['required', 'boolean'],
            'captions' => ['nullable', 'array'],
            'captions.*' => ['nullable', 'string', 'max:255'],
            'new_photos' => ['nullable', 'array', 'max:20'],
            'new_photos.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120', 'dimensions:min_width=720,min_height=480'],
            'new_photos_caption' => ['nullable', 'string', 'max:255'],
        ];
    }
}
