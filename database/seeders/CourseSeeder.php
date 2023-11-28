<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->truncate();

        DB::transaction(function () {
            $courses = json_decode(file_get_contents(resource_path('courses.json')));

            foreach ($courses as $course) {
                Course::factory()->create([
                    'title' => $course->title,
                    'description' => $course->description,
                    'code' => $course->code,
                    'credits' => $course->credits,
                    'instructor' => $course->instructor,
                    'department' => $course->department,
                    'location' => $course->location,
                    'enrollment_limit' => $course->enrollment_limit,
                    'fee' => $course->fee,
                ]);
            }
        });
    }
}
