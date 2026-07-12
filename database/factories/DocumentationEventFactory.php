<?php

namespace Database\Factories;

use App\Models\DocumentationEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DocumentationEvent>
 */
class DocumentationEventFactory extends Factory
{
    protected $model = DocumentationEvent::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'event_date' => fake()->date(),
            'location' => fake()->city(),
            'description' => fake()->paragraph(),
            'is_published' => true,
            'sort_order' => null,
        ];
    }
}
