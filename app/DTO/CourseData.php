<?php

declare(strict_types=1);

namespace App\DTO;

use Spatie\LaravelData\Data;

class CourseData extends Data
{
    public function __construct(
        public string $title,
        public string $description,
        public string $code,
        public int $credits,
        public string $instructor,
        public string $department,
        public string $location,
        public int $enrollment_limit,
        public float $fee,
    ) {
    }
}
