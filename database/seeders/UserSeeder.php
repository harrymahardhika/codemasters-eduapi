<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        DB::transaction(function () {
            for ($i = 0; $i < 10; $i++) {
                $n = $i + 1;

                \App\Models\User::factory()->create([
                    'email' => 'user'.$n.'@example.com',
                ]);
            }
        });
    }
}
