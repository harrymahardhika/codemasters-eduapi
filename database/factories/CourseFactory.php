<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Course '.fake()->unique()->numberBetween(1, 100),
            'description' => fake()->paragraph(),
            'code' => (string) fake()->unique()->numberBetween(1000, 9999),
            'credits' => fake()->numberBetween(1, 5),
            'instructor' => fake()->name(),
            'department' => 'Department '.fake()->unique()->numberBetween(1, 100),
            'location' => 'Location '.fake()->unique()->numberBetween(1, 100),
            'enrollment_limit' => fake()->numberBetween(1, 100),
            'fee' => fake()->numberBetween(1000, 9999),
        ];
    }
}
