<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\AuthenticationException;
use App\Exceptions\JsonResponseException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected string $tokenName = 'personal_access_token';

    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if (! $user) {
            throw new JsonResponseException(
                message: AuthenticationException::invalidEmail()->getMessage(),
                code: AuthenticationException::invalidEmail()->getCode(),
            );
        }

        $auth = Auth::attempt($credentials);
        if (! $auth) {
            throw new JsonResponseException(
                message: AuthenticationException::invalidCredentials()->getMessage(),
                code: AuthenticationException::invalidCredentials()->getCode(),
            );
        }

        $token = $user->createToken($this->tokenName)->plainTextToken;

        return $this->sendJsonResponse([
            'token' => $token,
        ]);
    }
}
