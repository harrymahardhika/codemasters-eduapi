<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\CourseData;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $courses = Course::when($request->filled('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%')
                ->orWhere('phone_number', 'like', '%'.$request->search.'%')
                ->orWhere('enroll_number', 'like', '%'.$request->search.'%');
        })
            ->paginate();

        $data = CourseData::collection($courses);

        return $this->sendJsonResponse($data);
    }

    public function show(Course $course): JsonResponse
    {
        return $this->sendJsonResponse(CourseData::from($course)->include('payments'));
    }
}
