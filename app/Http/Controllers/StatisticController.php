<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class StatisticController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return $this->sendJsonResponse([
            'students' => (int) Student::count(),
            'courses' => (int) Course::count(),
            'payments' => round((float) Payment::sum('amount'), 2),
            'users' => (int) User::count(),
        ]);
    }
}
