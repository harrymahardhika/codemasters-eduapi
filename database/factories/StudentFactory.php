<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone_number' => fake()->e164PhoneNumber(),
            'enroll_number' => fake()->swiftBicNumber(),
            'admission_date' => now()->subDays(fake()->numberBetween(365, 1000))->format('Y-m-d'),
        ];
    }
}
