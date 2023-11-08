<?php

declare(strict_types=1);

use App\Models\Course;

use function Pest\Laravel\actingAs;

it('can get courses', function () {
    $admin = createUser();
    $courses = \App\Models\Course::factory()->count(5)->create();

    $respose = actingAs($admin)
        ->getJson(route('api.courses.index'))
        ->assertOk();

    $courses->each(function (Course $course) use ($respose) {
        $respose->assertJsonFragment([
            'title' => $course->title,
            'description' => $course->description,
            'code' => $course->code,
            'credits' => $course->credits,
            'instructor' => $course->instructor,
            'department' => $course->department,
            'location' => $course->location,
            'enrollmentLimit' => $course->enrollment_limit,
            'fee' => $course->fee,
        ]);
    });
});

it('can get course', function () {
    $admin = createUser();
    $course = \App\Models\Course::factory()->create();

    actingAs($admin)
        ->getJson(route('api.courses.show', $course))
        ->assertOk()
        ->assertJsonFragment([
            'title' => $course->title,
            'description' => $course->description,
            'code' => $course->code,
            'credits' => $course->credits,
            'instructor' => $course->instructor,
            'department' => $course->department,
            'location' => $course->location,
            'enrollmentLimit' => $course->enrollment_limit,
            'fee' => $course->fee,
        ]);
});
