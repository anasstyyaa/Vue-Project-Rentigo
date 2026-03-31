<?php

namespace App\Controllers;

use App\Framework\Controller;
use App\Models\Rental;
use App\Services\Interfaces\IRentalService;
use App\Services\Interfaces\IAuthService;

class RentalController extends Controller
{
    private IRentalService $service;
    private IAuthService $authService;

    public function __construct(IRentalService $service, IAuthService $authService)
    {
        $this->service = $service;
        $this->authService = $authService;
    }

    /**
     * GET /api/my-bookings
     * Fetches bookings for the currently authenticated user
     */
    public function getMyBookings()
    {
        try {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                return $this->sendErrorResponse("Unauthorized: No token provided", 401);
            }

            $token = $matches[1];
            $user = $this->authService->getUserFromToken($token);

            if (!$user) {
                return $this->sendErrorResponse("Unauthorized: Invalid token", 401);
            }

            $bookings = $this->service->getRentalsByUserId($user->userId);

            return $this->sendSuccessResponse($bookings);

        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    /**
     * POST /api/bookings
     * Creates a new rental record
     */
    public function store()
    {
        try {
            /** @var Rental $rental */
            $rental = $this->mapPostDataToClass(Rental::class);

            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                return $this->sendErrorResponse("Unauthorized", 401);
            }

            $user = $this->authService->getUserFromToken($matches[1]);
            if (!$user) {
                return $this->sendErrorResponse("Session expired", 401);
            }

            $rental->userId = $user->userId;
            $savedRental = $this->service->create($rental);

            return $this->sendSuccessResponse([
                'message' => 'Booking successful!',
                'bookingId' => $savedRental->rentalId
            ], 201);

        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * POST /api/bookings/{id}/cancel
     */
    public function cancel($id)
    {
        try {
            $data = $this->getPostData();
            $reason = $data['reason'] ?? 'User cancelled via profile';

            $success = $this->service->cancel((int)$id, $reason);
            
            if ($success) {
                return $this->sendSuccessResponse(['message' => 'Booking cancelled successfully.']);
            }
            
            return $this->sendErrorResponse("Could not cancel booking.");
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage());
        }
    }
}