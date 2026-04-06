<?php

namespace App\Services\Interfaces;

use App\Models\Car;
use App\Models\CarImage;
use App\Repositories\Interfaces\ICarRepository;

interface ICarService
{ 
    public function getAll(int $page = 1, int $limit = 10): array;
    public function getById(int $id): ?Car;
    public function create(Car $car): ?Car;
    public function update(Car $car): bool;
    public function delete(int $id): bool;
    public function handleImageUploads(int $carId, array $files): void;
    public function addCarImage(CarImage $image): bool;
    public function setMainImage(int $carId, string $url): bool;
    public function deleteImageByUrl(string $url): bool; 
}