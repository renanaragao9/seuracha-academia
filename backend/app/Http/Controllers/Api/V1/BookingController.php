<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\Booking\BookingResource;
use App\Models\Booking;
use App\Services\Booking\IndexBookingService;
use App\Services\Booking\MyBookingService;
use App\Services\Booking\RegisterBookingService;
use App\Services\Booking\ShowBookingService;
use App\Services\Booking\UnregisterBookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends BaseController
{
    public function index(
        Request $request,
        IndexBookingService $indexBookingService
    ): JsonResponse {
        $bookings = $indexBookingService->run($request->user());

        return $this->successResponse(
            data: BookingResource::collection($bookings),
            message: 'Agendamentos carregados com sucesso.'
        );
    }

    public function show(
        Booking $booking,
        ShowBookingService $showBookingService
    ): JsonResponse {
        $booking = $showBookingService->run($booking);

        return $this->successResponse(
            data: new BookingResource($booking),
            message: 'Agendamento carregado com sucesso.'
        );
    }

    public function myBookings(
        Request $request,
        MyBookingService $myBookingService
    ): JsonResponse {
        $bookings = $myBookingService->run($request->user());

        return $this->successResponse(
            data: BookingResource::collection($bookings),
            message: 'Meus agendamentos carregados com sucesso.'
        );
    }

    public function register(
        Request $request,
        Booking $booking,
        RegisterBookingService $registerBookingService
    ): JsonResponse {
        $booking = $registerBookingService->run($request->user(), $booking);

        return $this->successResponse(
            data: new BookingResource($booking),
            message: 'Inscrição realizada com sucesso.'
        );
    }

    public function unregister(
        Request $request,
        Booking $booking,
        UnregisterBookingService $unregisterBookingService
    ): JsonResponse {
        $booking = $unregisterBookingService->run($request->user(), $booking);

        return $this->successResponse(
            data: new BookingResource($booking),
            message: 'Inscrição cancelada com sucesso.'
        );
    }
}
