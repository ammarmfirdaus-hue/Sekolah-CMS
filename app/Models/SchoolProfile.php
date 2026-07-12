<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    protected $fillable = [
        'school_name',
        'foundation_name',
        'tagline',
        'address',
        'phone',
        'email',
        'description',
        'logo',
        'banner_image',
        'maps_embed',
    ];
}
