<?php 

namespace App\Repositories\Interfaces;

use App\Models\Car;
use App\Models\CarImage;

interface ICarRepository
{
    /**
     * @return Car[]
     */
    
    public function getAll(int $page = 1, int $limit = 10): array;
    public function getById(int $id): ?Car;
    public function create(Car $car): ?Car;
    public function update(Car $car): bool;
    public function delete(int $id): bool;
    public function addCarImage(CarImage $image): bool;
    public function setMainImage(int $carId, string $url): bool;
    public function deleteImageByUrl(string $url): bool;
}
