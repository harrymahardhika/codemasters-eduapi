<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Foundation\Bus\Dispatchable;

abstract class Action
{
    use Dispatchable;

    abstract public function handle();
}
