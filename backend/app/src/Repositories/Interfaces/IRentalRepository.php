<?php

namespace App\Repositories\Interfaces;

use App\Models\Rental;

interface IRentalRepository
{
    public function getByUserId(int $userId): array;
    public function create(Rental $rental): ?Rental; 
    public function cancel(int $rentalId, string $reason): bool;
    public function isCarBooked(int $carId, string $startDate, string $endDate): bool; 
    public function getAllBookings(): array; 
}