<?php

namespace App\Services;

use App\Models\Car;
use App\Repositories\Interfaces\ICarRepository;
use App\Services\Interfaces\ICarService;

class CarService implements ICarService
{
    private ICarRepository $repository;

    public function __construct(ICarRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Car[]
     */
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function getById(int $id): ?Car
    {
        return $this->repository->getById($id);
    }

    public function create(Car $car): ?Car
    {
        return $this->repository->create($car);
    }

    public function update(Car $car): bool
    {
        return $this->repository->update($car);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}