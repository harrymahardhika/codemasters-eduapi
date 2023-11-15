<?php

declare(strict_types=1);

namespace App\DTO;

use App\Models\Student;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class StudentData extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public string $phone_number,
        public ?string $enroll_number,
        public string $admission_date,
        public ?string $image_url,
        #[DataCollectionOf(PaymentData::class)]
        public DataCollection|Lazy|null $payments,
    ) {
    }

    public static function fromModel(Student $student): self
    {
        return new self(
            id: $student->id,
            name: $student->name,
            email: $student->email,
            phone_number: $student->phone_number,
            enroll_number: $student->enroll_number,
            admission_date: $student->admission_date,
            image_url: $student->image ? asset('storage/'.$student->image) : null,
            payments: Lazy::create(fn () => PaymentData::collection($student->payments)),
        );
    }
}
