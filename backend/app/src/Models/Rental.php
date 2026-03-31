<?php

namespace App\Models;

class Rental
{
    public int $rentalId;
    public int $userId;
    public int $carId;
    public string $startDate;
    public string $endDate;
    public float $dailyPrice; // maps to PricePerDayAtBooking
    public float $totalPrice;
    public string $status;
    public ?string $carName = null;  // from Join
    public ?string $carImage = null; // from Join
}