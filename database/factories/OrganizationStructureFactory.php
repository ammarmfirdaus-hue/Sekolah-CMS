<?php

namespace Database\Factories;

use App\Models\OrganizationStructure;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationStructureFactory extends Factory
{
    protected $model = OrganizationStructure::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'position' => fake()->jobTitle(),
            'photo' => null,
            'description' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(1, 100),
            'is_active' => true,
        ];
    }
}
