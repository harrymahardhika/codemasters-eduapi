<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'schedule',
        'amount',
        'balance',
        'payment_date',
    ];

    protected $casts = [
        'amount' => 'float',
        'balance' => 'float',
    ];

    protected static function booted()
    {
        static::saving(function (Payment $payment) {
            $payment->balance = self::calculateBalance($payment);
            $payment->number = self::generateNumber($payment);
        });
    }

    private static function generateNumber(Payment $payment): string
    {
        $parts = collect([
            'PAY',
            date('Ymd', strtotime($payment->payment_date)),
            rand(1000, 9999),
        ]);

        return $parts->implode('-');
    }

    private static function calculateBalance(Payment $payment): float
    {
        $balance = Payment::where('student_id', $payment->student_id)
            ->when($payment->id, fn ($query) => $query->where('id', '!=', $payment->id))
            ->sum('amount');

        return $balance + $payment->amount;
    }
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
