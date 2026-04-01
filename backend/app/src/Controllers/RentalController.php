<?php

namespace App\Controllers;

use App\Framework\Controller;
use App\Models\Rental;
use App\Services\Interfaces\IRentalService;
use App\Services\Interfaces\IAuthService;

class RentalController extends Controller
{
    private IRentalService $service;

    public function __construct(IRentalService $service, IAuthService $authService)
    {
        parent::__construct($authService);
        $this->service = $service;
    }

    public function getMyBookings()
    {
        try {
            $user = $this->getAuthenticatedUser();
            $bookings = $this->service->getRentalsByUserId($user->userId);

            return $this->sendSuccessResponse($bookings);

        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function store()
    {
        try {
            /** @var Rental $rental */
            $rental = $this->mapPostDataToClass(Rental::class);
            $user = $this->getAuthenticatedUser();

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