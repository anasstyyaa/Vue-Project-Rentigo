<?php
namespace App\Services\Interfaces;

use App\Models\Rental;

interface IRentalService
{
    public function getRentalsByUserId(int $userId): array;
    public function getAll(): array;
    public function create(Rental $rental): ?Rental;
    public function cancel(int $id, string $reason): bool;
    public function isCarBooked(int $carId, string $startDate, string $endDate): bool; 
}