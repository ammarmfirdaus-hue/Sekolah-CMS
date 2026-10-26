<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrationInformationRequest extends FormRequest
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
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'process' => ['nullable', 'string'],
            'schedule' => ['nullable', 'string'],
            'contact_info' => ['nullable', 'string'],
            'is_open' => ['required', 'boolean'],
            'cta_text' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'string', 'max:255'],
        ];
    }
}
