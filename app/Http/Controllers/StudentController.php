<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\SaveStudent;
use App\DTO\StudentData;
use App\Exceptions\JsonResponseException;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $students = Student::when($request->filled('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%')
                ->orWhere('phone_number', 'like', '%'.$request->search.'%')
                ->orWhere('enroll_number', 'like', '%'.$request->search.'%');
        })
            ->paginate();

        $data = StudentData::collection($students);

        return $this->sendJsonResponse($data);
    }

    public function show(Student $student): JsonResponse
    {
        return $this->sendJsonResponse(StudentData::from($student)->include('payments'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:students,email',
            'phone_number' => 'required|string',
            'admission_date' => 'required|date',
        ]);

        dispatch_sync(new SaveStudent(
            student: new Student(),
            data: StudentData::from($request->all()),
            image: $request->file('image'),
        ));

        return $this->sendJsonResponse([
            'message' => __('app.data_created', ['data' => __('app.student')]),
        ]);
    }

    public function update(Request $request, Student $student): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:students,email,'.$student->id,
            'phone_number' => 'required|string',
            'admission_date' => 'required|date',
        ]);

        dispatch_sync(new SaveStudent(
            student: $student,
            data: StudentData::from($request->all()),
            image: $request->file('image'),
        ));

        return $this->sendJsonResponse([
            'message' => __('app.data_updated', ['data' => __('app.student')]),
        ]);
    }

    public function destroy(Student $student): JsonResponse
    {
        try {
            $student->delete();

            return $this->sendJsonResponse([
                'message' => __('app.data_deleted', ['data' => __('app.student')]),
            ]);
        } catch (\Throwable $throwable) {
            throw new JsonResponseException($throwable->getMessage(), 400);
        }
    }
}
