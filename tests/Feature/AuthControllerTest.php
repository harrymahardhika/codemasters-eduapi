<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\post;

it('can get token', function () {
    $password = \Illuminate\Support\Str::random(10);
    $user = User::factory()->create([
        'password' => $password,
    ]);

    $request = [
        'email' => $user->email,
        'password' => $password,
    ];

    post('/api/auth', $request)
        ->assertOk()
        ->assertJsonStructure(['token']);
});
