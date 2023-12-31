<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\SavePayment;
use App\DTO\PaymentData;
use App\Exceptions\JsonResponseException;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $payments = Payment::with('student')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('schedule', 'like', '%'.$request->search.'%')
                    ->orWhere('amount', 'like', '%'.$request->search.'%')
                    ->orWhere('payment_date', 'like', '%'.$request->search.'%');
            })
            ->paginate();

        $data = PaymentData::collection($payments);

        return $this->sendJsonResponse($data);
    }

    public function show(Payment $payment): JsonResponse
    {
        return $this->sendJsonResponse(PaymentData::from($payment));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate($this->getValidationRules());

        dispatch_sync(new SavePayment(
            new Payment(),
            PaymentData::from($request->all())
        ));

        return $this->sendJsonResponse([
            'message' => __('app.data_created', ['data' => __('app.payment')]),
        ]);
    }

    public function update(Request $request, Payment $payment): JsonResponse
    {
        $request->validate($this->getValidationRules());

        dispatch_sync(new SavePayment(
            $payment,
            PaymentData::from($request->all())
        ));

        return $this->sendJsonResponse([
            'message' => __('app.data_updated', ['data' => __('app.payment')]),
        ]);
    }

    public function destroy(Payment $payment): JsonResponse
    {
        try {
            $payment->delete();

            return $this->sendJsonResponse([
                'message' => __('app.data_deleted', ['data' => __('app.payment')]),
            ]);
        } catch (\Throwable $throwable) {
            throw new JsonResponseException(
                $throwable->getMessage(),
                $throwable->getCode()
            );
        }
    }

    private function getValidationRules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'schedule' => 'required|in:monthly,quarterly,yearly',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
        ];
    }
}
