<?php

namespace App\Services\Interfaces;

use App\Models\Car;
use App\Repositories\Interfaces\ICarRepository;

interface ICarService
{ 
    public function getAll(): array;
    public function getById(int $id): ?Car;
    public function create(Car $car): ?Car;
    public function update(Car $car): bool;
    public function delete(int $id): bool;
}