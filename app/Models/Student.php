<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\StudentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'enroll_number',
        'admission_date',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Student $student) {
            $student->enroll_number = static::generateEnrollNumber();
        });

        static::deleting(function (Student $student) {
            if ($student->payments()->count() > 0) {
                throw StudentException::studentHasPayments($student);
            }
        });
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    private static function generateEnrollNumber(): string
    {
        $number = '';
        for ($i = 0; $i < 10; $i++) {
            $number .= rand(0, 9);
        }

        return $number;
    }
}
