<?php 

namespace App\Repositories;

use App\Framework\Repository;
use App\Repositories\Interfaces\ICarRepository;
use App\Models\Car;
use PDO;

class CarRepository extends Repository implements ICarRepository
{
    public function getAll(): array{
        $sql = "SELECT 
                CarId AS carId, 
                Brand AS brand, 
                Model AS model, 
                Year AS year, 
                PricePerDay AS pricePerDay, 
                Transmission AS transmission, 
                FuelType AS fuelType, 
                Seats AS seats, 
                Color AS color, 
                Description AS description, 
                IsAvailable AS isAvailable, 
                CreatedAt AS createdAt, 
                IsDeleted AS isDeleted 
            FROM Cars 
            WHERE IsDeleted = 0";

        $stmt = $this->getConnection()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Car::class);
    }

    public function getById(int $id): ?Car{
        $sql = "SELECT 
                CarId AS carId, 
                Brand AS brand, 
                Model AS model, 
                Year AS year, 
                PricePerDay AS pricePerDay, 
                Transmission AS transmission, 
                FuelType AS fuelType, 
                Seats AS seats, 
                Color AS color, 
                Description AS description, 
                IsAvailable AS isAvailable, 
                CreatedAt AS createdAt, 
                IsDeleted AS isDeleted 
            FROM Cars 
            WHERE CarId = :id AND IsDeleted = 0";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $car = $stmt->fetchObject(Car::class);
        return $car ?: null;
    }

    public function create(Car $car): bool{
       $sql = "INSERT INTO Cars (brand, model, year, pricePerDay, transmission, fuelType, seats, color, description, isAvailable) 
                VALUES (:brand, :model, :year, :pricePerDay, :transmission, :fuelType, :seats, :color, :description, :isAvailable)";

       $stmt = $this->getConnection()->prepare($sql);
      
       return $stmt->execute([
            ':brand' => $car->brand,
            ':model' => $car->model,
            ':year' => $car->year,
            ':pricePerDay' => $car->pricePerDay,
            ':transmission' => $car->transmission,
            ':fuelType' => $car->fuelType,
            ':seats' => $car->seats,
            ':color' => $car->color,
            ':description' => $car->description,
            ':isAvailable' => (int)$car->isAvailable
        ]);
    }

    public function update(Car $car): bool{
        $sql = "UPDATE Cars SET 
                brand = :brand, model = :model, year = :year, pricePerDay = :pricePerDay, 
                transmission = :transmission, fuelType = :fuelType, seats = :seats, 
                color = :color, description = :description, isAvailable = :isAvailable 
                WHERE carId = :carId";
                
        $stmt = $this->getConnection()->prepare($sql);

        return $stmt->execute([
            ':brand' => $car->brand,
            ':model' => $car->model,
            ':year' => $car->year,
            ':pricePerDay' => $car->pricePerDay,
            ':transmission' => $car->transmission,
            ':fuelType' => $car->fuelType,
            ':seats' => $car->seats,
            ':color' => $car->color,
            ':description' => $car->description,
            ':isAvailable' => (int)$car->isAvailable,
            ':carId' => $car->carId
        ]);
    }

    public function delete(int $id): bool{
        $sql = "UPDATE Cars SET isDeleted = 1 WHERE carId = :id";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

}