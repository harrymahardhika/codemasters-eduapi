<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('can get the statistics', function () {
    $admin = createUser();

    $students = Student::factory(fake()->numberBetween(5, 10))->create();
    $studentsTotal = $students->count();

    $courses = Course::factory(fake()->numberBetween(5, 10))->create();
    $coursesTotal = $courses->count();

    $payments = Payment::factory(fake()->numberBetween(5, 10))
        ->sequence(fn () => ['student_id' => $students->random()->id])
        ->create();

    $paymentsTotal = round($payments->sum('amount'), 2);

    $users = User::factory(fake()->numberBetween(5, 10))->create();
    $usersTotal = $users->count() + 1;

    actingAs($admin)
        ->getJson(route('api.statistics.index'))
        ->assertOk()
        ->assertJsonFragment([
            'students' => $studentsTotal,
            'courses' => $coursesTotal,
            'payments' => $paymentsTotal,
            'users' => $usersTotal,
        ]);
});
