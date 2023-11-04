<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payments')->truncate();

        $students = Student::all();
        DB::transaction(function () use ($students) {
            Payment::factory()
                ->count(20)
                ->sequence(fn () => [
                    'student_id' => $students->random()->id,
                ])
                ->create();
        });
    }
}
