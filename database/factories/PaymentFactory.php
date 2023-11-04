<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => fn () => Student::factory()->create()->id,
            'schedule' => fake()->randomElement(['monthly', 'quarterly', 'yearly']),
            'amount' => fake()->randomFloat(2, 1000, 10000),
            'balance' => fake()->randomFloat(2, 1000, 10000),
            'payment_date' => now()->subDays(fake()->numberBetween(50, 100))->format('Y-m-d'),
        ];
    }
}
