<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\StudentData;
use App\Models\Student;

class SaveStudent extends Action
{
    public function __construct(
        private readonly Student $student,
        private readonly StudentData $data,
    ) {
    }

    public function handle()
    {
        $this->student->fill([
            'name' => $this->data->name,
            'email' => $this->data->email,
            'phone_number' => $this->data->phone_number,
            'admission_date' => $this->data->admission_date,
        ]);
        $this->student->save();
    }
}
