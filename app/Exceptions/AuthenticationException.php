<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;

class AuthenticationException extends \Exception
{
    public function __construct(string $message = '', int $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function invalidCredentials(): self
    {
        return new self('Invalid credentials');
    }

    public static function invalidEmail(): self
    {
        return new self('Invalid email');
    }

    public static function userBlocked(): self
    {
        return new self('User blocked');
    }
}
