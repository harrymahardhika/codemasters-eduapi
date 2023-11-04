<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->truncate();

        DB::transaction(function () {
            Student::factory()->count(10)->create();
        });
    }
}
