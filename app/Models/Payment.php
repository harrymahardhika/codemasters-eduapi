<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Payment
 *
 * @method static PaymentFactory  factory($count = null, $state = [])
 * @method static Builder|Payment newModelQuery()
 * @method static Builder|Payment newQuery()
 * @method static Builder|Payment onlyTrashed()
 * @method static Builder|Payment query()
 * @method static Builder|Payment whereAmount($value)
 * @method static Builder|Payment whereBalance($value)
 * @method static Builder|Payment whereCreatedAt($value)
 * @method static Builder|Payment whereDeletedAt($value)
 * @method static Builder|Payment whereId($value)
 * @method static Builder|Payment whereNumber($value)
 * @method static Builder|Payment wherePaymentDate($value)
 * @method static Builder|Payment whereSchedule($value)
 * @method static Builder|Payment whereStudentId($value)
 * @method static Builder|Payment whereUpdatedAt($value)
 * @method static Builder|Payment withTrashed()
 * @method static Builder|Payment withoutTrashed()
 *
 * @mixin \Eloquent
 *
 * @property      int         $id
 * @property      int         $student_id
 * @property      string      $number
 * @property      string      $schedule
 * @property      float       $amount
 * @property      float       $balance
 * @property      string      $payment_date
 * @property      Carbon|null $deleted_at
 * @property      Carbon|null $created_at
 * @property      Carbon|null $updated_at
 * @property-read Student     $student
 */
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

    protected static function booted(): void
    {
        static::saving(function (Payment $payment) {
            $payment->balance = self::calculateBalance($payment);
            $payment->number = self::generateNumber($payment);
        });
    }

    private static function calculateBalance(Payment $payment): float
    {
        $balance = self::where('student_id', $payment->student_id)
            ->when($payment->id, fn ($query) => $query->where('id', '!=', $payment->id))
            ->sum('amount');

        return $balance + $payment->amount;
    }

    /**
     * @throws \Exception
     */
    private static function generateNumber(Payment $payment): string
    {
        $parts = collect([
            'PAY',
            date('Ymd', (int) strtotime($payment->payment_date)),
            random_int(1000, 9999),
        ]);

        return $parts->implode('-');
    }

    /**
     * @return BelongsTo<Student, self>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
