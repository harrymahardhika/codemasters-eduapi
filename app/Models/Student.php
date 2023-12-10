<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\StudentException;
use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Student
 *
 * @method static StudentFactory  factory($count = null, $state = [])
 * @method static Builder|Student newModelQuery()
 * @method static Builder|Student newQuery()
 * @method static Builder|Student onlyTrashed()
 * @method static Builder|Student query()
 * @method static Builder|Student whereAdmissionDate($value)
 * @method static Builder|Student whereCreatedAt($value)
 * @method static Builder|Student whereDeletedAt($value)
 * @method static Builder|Student whereEmail($value)
 * @method static Builder|Student whereEnrollNumber($value)
 * @method static Builder|Student whereId($value)
 * @method static Builder|Student whereImage($value)
 * @method static Builder|Student whereName($value)
 * @method static Builder|Student wherePhoneNumber($value)
 * @method static Builder|Student whereUpdatedAt($value)
 * @method static Builder|Student withTrashed()
 * @method static Builder|Student withoutTrashed()
 *
 * @mixin \Eloquent
 *
 * @property      int                      $id
 * @property      string                   $name
 * @property      string                   $email
 * @property      string                   $phone_number
 * @property      string                   $enroll_number
 * @property      string                   $admission_date
 * @property      string|null              $image
 * @property      Carbon|null              $deleted_at
 * @property      Carbon|null              $created_at
 * @property      Carbon|null              $updated_at
 * @property-read Collection<int, Payment> $payments
 * @property-read int|null                 $payments_count
 */
class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'enroll_number',
        'admission_date',
        'image',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Student $student) {
            $student->enroll_number = self::generateEnrollNumber();
        });

        static::deleting(function (Student $student) {
            if ($student->payments()->count() > 0) {
                throw StudentException::studentHasPayments($student);
            }
        });
    }

    /**
     * @return HasMany<Payment>
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * @throws \Exception
     */
    private static function generateEnrollNumber(): string
    {
        $number = '';
        for ($i = 0; $i < 10; $i++) {
            $number .= random_int(0, 9);
        }

        return $number;
    }
}
