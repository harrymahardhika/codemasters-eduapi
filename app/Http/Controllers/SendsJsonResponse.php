<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

trait SendsJsonResponse
{
    public function sendJsonResponse(mixed $content, int $code = 200): JsonResponse
    {
        return response()->json($content, $code);
    }
}
