<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationInformation extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'requirements',
        'process',
        'schedule',
        'contact_info',
        'is_open',
        'cta_text',
        'cta_url',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
        ];
    }
}
