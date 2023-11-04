<?php

declare(strict_types=1);

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
)->in('Feature');

function createUser(): App\Models\User
{
    return \App\Models\User::factory()->create();
}
