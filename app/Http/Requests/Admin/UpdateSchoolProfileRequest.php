<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolProfileRequest extends FormRequest
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
            'foundation_name' => ['nullable', 'string', 'max:255'],
            'school_name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'maps_embed' => ['nullable', 'string'],
            'logo' => ['nullable', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
            'banner_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
        ];
    }
}
