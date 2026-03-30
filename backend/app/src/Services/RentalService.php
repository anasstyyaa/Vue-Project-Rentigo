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
        $start = new \DateTime($rental->getStartDate('startDate'));
        $end = new \DateTime($rental->getEndDate('endDate'));
        
        if ($end <= $start) {
            throw new \Exception("End date must be after the start date.");
        }

        $car = $this->carRepository->getById($rental->getCarId('carId'));
        if (!$car) {
            throw new \Exception("The selected car does not exist.");
        }

        $interval = $start->diff($end);
        $days = $interval->days === 0 ? 1 : $interval->days; 
        
        $rental->setDailyPrice((float)$car->pricePerDay); 
        $rental->setTotalPrice($rental->getDailyPrice() * $days);
        $rental->setStatus('Booked');

        if ($this->rentalRepository->isCarBooked($rental->getCarId('carId'), $rental->getStartDate('startDate'), $rental->getEndDate('endDate'))) {
            throw new \Exception("This car is already booked for these dates.");
        }

        $rental->setStatus('Booked');
        return $this->rentalRepository->create($rental);
    }

    public function cancel(int $id, string $reason): bool
    {
        if (empty($reason)) {
            throw new \Exception("A reason for cancellation is required.");
        }

        // Business Rule: Can't cancel if the rental already started
        // You would fetch the rental first and check the StartDate here.
        
        return $this->rentalRepository->cancel($id, $reason);
    }
}