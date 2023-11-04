<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Models\Student;

class StudentException extends \Exception
{
    public static function studentHasPayments(Student $student): self
    {
        return new self("Student {$student->name} has payments");
    }
}
