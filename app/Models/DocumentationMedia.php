<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentationMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'documentation_event_id',
        'type',
        'path',
        'embed_url',
        'thumbnail_path',
        'caption',
        'sort_order',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    public function documentationEvent(): BelongsTo
    {
        return $this->belongsTo(DocumentationEvent::class);
    }

    public function isPhoto(): bool
    {
        return $this->type === 'photo';
    }

    public function isVideoEmbed(): bool
    {
        return $this->type === 'video_embed';
    }

    public function publicUrl(): ?string
    {
        if ($this->isPhoto() && $this->path) {
            return asset('storage/'.ltrim($this->path, '/'));
        }

        return null;
    }
}
