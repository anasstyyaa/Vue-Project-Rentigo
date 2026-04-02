<?php

namespace App\Services; 

use App\Repositories\Interfaces\IRentalRepository;
use App\Models\Rental;
use App\Services\Interfaces\IRentalService;
use App\Repositories\Interfaces\ICarRepository;

class RentalService implements IRentalService   
{
    private IRentalRepository $rentalRepository;
    private ICarRepository $carRepository;

    public function __construct(IRentalRepository $rentalRepository, ICarRepository $carRepository)
    {
        $this->rentalRepository = $rentalRepository;
        $this->carRepository = $carRepository;
    }

    public function getRentalsByUserId(int $userId): array {
        return $this->rentalRepository->getByUserId($userId);
    }

    public function getAll() : array {
        return $this->rentalRepository->getAll();
    }

    public function create(Rental $rental): ?Rental
    {
        $start = new \DateTime($rental->startDate);
        $end = new \DateTime($rental->endDate);
        
        if ($end <= $start) {
            throw new \Exception("End date must be after the start date.");
        }

        $car = $this->carRepository->getById($rental->carId);
        if (!$car) {
            throw new \Exception("The selected car does not exist.");
        }

        $interval = $start->diff($end);
        $days = $interval->days === 0 ? 1 : $interval->days; 
        
        $rental->dailyPrice = (float)$car->pricePerDay;
        $rental->totalPrice = $rental->dailyPrice * $days;
        $rental->status = 'Booked';

        if ($this->rentalRepository->isCarBooked($rental->carId, $rental->startDate, $rental->endDate)) {
            throw new \Exception("This car is already booked for these dates.");
        }

        return $this->rentalRepository->create($rental);
    }

    public function cancel(int $id, string $reason): bool
    {
        if (empty($reason)) {
            throw new \Exception("A reason for cancellation is required.");
        }
        return $this->rentalRepository->cancel($id, $reason);
    }

    public function isCarBooked(int $carId, string $startDate, string $endDate): bool
    {
        return $this->rentalRepository->isCarBooked($carId, $startDate, $endDate);
    }

    public function getAllBookings(): array
    {
        return $this->rentalRepository->getAllBookings();
    }
}