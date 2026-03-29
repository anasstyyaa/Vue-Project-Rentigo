<?php

namespace App\Models;

class Car
{
    public int $carId = 0;
    public string $brand = "";
    public string $model = "";
    public int $year = 0;
    public float $pricePerDay = 0.0;
    public string $transmission = "";
    public string $fuelType = "";
    public int $seats = 0;
    public ?string $color = null;
    public ?string $description = null;
    public bool $isAvailable = true;
    public string $createdAt = "";
    public bool $isDeleted = false;
    public array $images = []; 
    public ?string $image = null;
}


