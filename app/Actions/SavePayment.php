<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\PaymentData;
use App\Models\Payment;

class SavePayment extends Action
{
    public function __construct(
        private readonly Payment $payment,
        private readonly PaymentData $data,
    ) {
    }

    public function handle()
    {
        $this->payment->fill([
            'schedule' => $this->data->schedule,
            'amount' => $this->data->amount,
            'payment_date' => $this->data->payment_date,
        ]);

        if (! $this->payment->id) {
            $this->payment->student()->associate($this->data->student_id);
        }

        $this->payment->save();
    }
}
