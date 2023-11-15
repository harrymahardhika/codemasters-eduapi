<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\StudentData;
use App\Models\Student;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SaveStudent extends Action
{
    public function __construct(
        private readonly Student $student,
        private readonly StudentData $data,
        private readonly ?UploadedFile $image = null,
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

        if ($this->image) {
            if ($this->student->id && $this->student->image) {
                Storage::delete('public/'.$this->student->image);
            }

            $filepath = Storage::putFile('public', $this->image);
            $this->student->image = str_replace('public/', '', $filepath);
        }

        $this->student->save();
    }
}
