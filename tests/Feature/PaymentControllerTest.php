<?php

declare(strict_types=1);

use App\Models\Payment;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;

it('can get payments', function () {
    $admin = createUser();
    $payments = \App\Models\Payment::factory()->count(5)->create();

    $respose = actingAs($admin)
        ->getJson(route('api.payments.index'))
        ->assertOk();

    $payments->each(function (Payment $payment) use ($respose) {
        $respose->assertJsonFragment([
            'id' => $payment->id,
            'studentId' => $payment->student_id,
            'schedule' => $payment->schedule,
            'amount' => $payment->amount,
            'paymentDate' => $payment->payment_date,
        ]);
    });
});

it('can get payment', function () {
    $admin = createUser();
    $payment = \App\Models\Payment::factory()->create();

    actingAs($admin)
        ->getJson(route('api.payments.show', $payment))
        ->assertOk()
        ->assertJsonFragment([
            'id' => $payment->id,
            'studentId' => $payment->student_id,
            'schedule' => $payment->schedule,
            'amount' => $payment->amount,
            'paymentDate' => $payment->payment_date,
        ]);
});

it('can store payment', function () {
    $admin = createUser();
    $request = Payment::factory()->make();

    actingAs($admin)
        ->postJson(route('api.payments.store'), $request->toArray())
        ->assertOk();

    assertDatabaseHas('payments', [
        'student_id' => $request->student_id,
        'schedule' => $request->schedule,
        'amount' => $request->amount,
        'payment_date' => $request->payment_date,
    ]);
});

it('can update payment', function () {
    $admin = createUser();
    $payment = Payment::factory()->create();
    $request = Payment::factory()->make();

    actingAs($admin)
        ->putJson(route('api.payments.update', $payment), $request->toArray())
        ->assertOk();

    $payment->refresh();
    expect($payment->student_id)->toBe($payment->student_id)
        ->and($payment->schedule)->toBe($request->schedule)
        ->and($payment->amount)->toBe($request->amount)
        ->and($payment->payment_date)->toBe($request->payment_date);
});

it('can delete payment', function () {
    $admin = createUser();
    $payment = Payment::factory()->create();

    actingAs($admin)
        ->deleteJson(route('api.payments.destroy', $payment))
        ->assertOk();

    assertSoftDeleted('payments', [
        'id' => $payment->id,
    ]);
});
