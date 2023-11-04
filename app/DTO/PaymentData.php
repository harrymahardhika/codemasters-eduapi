<?php

declare(strict_types=1);

namespace App\DTO;

use App\Models\Payment;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class PaymentData extends Data
{
    public function __construct(
        public ?int $id,
        public ?string $number,
        public ?int $student_id,
        public string $schedule,
        public float $amount,
        public ?float $balance,
        public string $payment_date,
        public StudentData|Lazy|null $student,
    ) {
    }

    public static function fromModel(Payment $payment): self
    {
        return new self(
            id: $payment->id,
            number: $payment->number,
            student_id: $payment->student_id,
            schedule: $payment->schedule,
            amount: $payment->amount,
            balance: $payment->balance,
            payment_date: $payment->payment_date,
            student: Lazy::create(fn () => StudentData::fromModel($payment->student)),
        );
    }
}
