<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth', AuthController::class)->name('auth');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', function (Request $request) {
        return $request->user();
    })->name('me');

    Route::apiResource('students', StudentController::class);
    Route::apiResource('payments', PaymentController::class);
});
