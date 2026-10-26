<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationStructureRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
