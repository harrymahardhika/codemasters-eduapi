<?php

declare(strict_types=1);

use App\Exceptions\StudentException;
use App\Models\Payment;
use App\Models\Student;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;

it('can get students', function () {
    $admin = createUser();
    $students = \App\Models\Student::factory()->count(5)->create();

    $respose = actingAs($admin)
        ->getJson(route('api.students.index'))
        ->assertOk();

    $students->each(function (Student $student) use ($respose) {
        $respose->assertJsonFragment([
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'phoneNumber' => $student->phone_number,
            'admissionDate' => $student->admission_date,
        ]);
    });
});

it('can get student', function () {
    $admin = createUser();
    $student = \App\Models\Student::factory()->create();

    actingAs($admin)
        ->getJson(route('api.students.show', $student))
        ->assertOk()
        ->assertJsonFragment([
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'phoneNumber' => $student->phone_number,
            'admissionDate' => $student->admission_date,
        ]);
});

it('can store student', function () {
    $admin = createUser();
    $request = Student::factory()->make();

    actingAs($admin)
        ->postJson(route('api.students.store'), $request->toArray())
        ->assertOk()
        ->assertJson([
            'message' => __('app.data_created', ['data' => __('app.student')]),
        ]);

    assertDatabaseHas('students', [
        'name' => $request->name,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'admission_date' => $request->admission_date,
    ]);
});

it('can update student', function () {
    $admin = createUser();
    $student = Student::factory()->create();
    $request = Student::factory()->make();

    actingAs($admin)
        ->putJson(route('api.students.update', $student), $request->toArray())
        ->assertOk()
        ->assertJson([
            'message' => __('app.data_updated', ['data' => __('app.student')]),
        ]);

    $student->refresh();

    expect($student->name)->toBe($request->name)
        ->and($student->email)->toBe($request->email)
        ->and($student->phone_number)->toBe($request->phone_number)
        ->and($student->admission_date)->toBe($request->admission_date);
});

it('can delete student', function () {
    $admin = createUser();
    $student = Student::factory()->create();

    actingAs($admin)
        ->deleteJson(route('api.students.destroy', $student))
        ->assertOk()
        ->assertJson([
            'message' => __('app.data_deleted', ['data' => __('app.student')]),
        ]);

    assertSoftDeleted('students', [
        'id' => $student->id,
    ]);
});

it("won't delete student if it has payments", function () {
    $admin = createUser();
    $student = \App\Models\Student::factory()->create();
    Payment::factory()->create(['student_id' => $student->id]);

    actingAs($admin)
        ->deleteJson(route('api.students.destroy', $student))
        ->assertStatus(400)
        ->assertJson([
            'error' => StudentException::studentHasPayments($student)->getMessage(),
        ]);
});
