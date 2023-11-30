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
            $query->where('title', 'like', '%'.$request->search.'%')
                ->orWhere('description', 'like', '%'.$request->search.'%')
                ->orWhere('code', 'like', '%'.$request->search.'%')
                ->orWhere('credits', 'like', '%'.$request->search.'%')
                ->orWhere('instructor', 'like', '%'.$request->search.'%')
                ->orWhere('department', 'like', '%'.$request->search.'%')
                ->orWhere('location', 'like', '%'.$request->search.'%')
                ->orWhere('enrollment_limit', 'like', '%'.$request->search.'%')
                ->orWhere('fee', 'like', '%'.$request->search.'%');
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
