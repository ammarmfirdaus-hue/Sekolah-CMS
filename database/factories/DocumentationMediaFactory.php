<?php

namespace Database\Factories;

use App\Models\DocumentationEvent;
use App\Models\DocumentationMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DocumentationMedia>
 */
class DocumentationMediaFactory extends Factory
{
    protected $model = DocumentationMedia::class;

    public function definition(): array
    {
        return [
            'documentation_event_id' => DocumentationEvent::factory(),
            'type' => 'photo',
            'path' => 'documentation/events/'.fake()->numberBetween(1, 100).'/'.fake()->uuid().'.jpg',
            'embed_url' => null,
            'thumbnail_path' => null,
            'caption' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(1, 100),
            'is_featured' => false,
        ];
    }
}
