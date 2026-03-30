<?php

namespace App\Models;

class Rental
{
    private int $rentalId;
    private int $userId;
    private int $carId;
    private string $startDate;
    private string $endDate;
    private float $dailyPrice; // maps to PricePerDayAtBooking
    private float $totalPrice;
    private string $status;
    private ?string $carName = null;  // from Join
    private ?string $carImage = null; // from Join

    public function __construct() {
        $this->rentalId = 0;
        $this->userId = 0;
        $this->carId = 0;
        $this->startDate = "";
        $this->endDate = "";
        $this->dailyPrice = 0.0;
        $this->totalPrice = 0.0;
        $this->status = "Pending";
        $this->carName = null;
        $this->carImage = null;
    }

    public function getRentalId(): int { return $this->rentalId; }
    public function getUserId(): int { return $this->userId;}
    public function getCarId(): int { return $this->carId; }
    public function getStartDate(): string { return $this->startDate; }
    public function getEndDate(): string { return $this->endDate; }
    public function getDailyPrice(): float { return $this->dailyPrice; }
    public function getTotalPrice(): float { return $this->totalPrice; }
    public function getStatus(): string { return $this->status; }
    public function getCarName(): ?string { return $this->carName; }
    public function getCarImage(): ?string { return $this->carImage; }

    public function setRentalId(int $rentalId): void { $this->rentalId = $rentalId; }
    public function setUserId(int $userId): void { $this->userId = $userId; }
    public function setCarId(int $carId): void { $this->carId = $carId; }
    public function setStartDate(string $startDate): void { $this->startDate = $startDate; }
    public function setEndDate(string $endDate): void { $this->endDate = $endDate; }
    public function setDailyPrice(float $dailyPrice): void { $this->dailyPrice = $dailyPrice; }
    public function setTotalPrice(float $totalPrice): void { $this->totalPrice = $totalPrice; }
    public function setStatus(string $status): void { $this->status = $status; }
    public function setCarName(?string $carName): void { $this->carName = $carName; }
    public function setCarImage(?string $carImage): void { $this->carImage = $carImage; }
}