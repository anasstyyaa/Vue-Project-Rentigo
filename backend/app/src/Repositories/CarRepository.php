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
                    c.CarId AS carId, 
                    c.Brand AS brand, 
                    c.Model AS model, 
                    c.Year AS year, 
                    c.PricePerDay AS pricePerDay, 
                    c.Transmission AS transmission, 
                    c.FuelType AS fuelType, 
                    c.Seats AS seats, 
                    c.Color AS color, 
                    c.IsAvailable AS isAvailable,
                    (SELECT ImageUrl FROM CarImages WHERE CarId = c.CarId ORDER BY IsMainImage DESC LIMIT 1) AS image
                FROM Cars c
                WHERE c.IsDeleted = 0";

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
        
        if (!$car) return null; 

        $imgSql = "SELECT ImageUrl FROM CarImages WHERE CarId = :id ORDER BY IsMainImage DESC LIMIT 4";
        $imgStmt = $this->getConnection()->prepare($imgSql);
        $imgStmt->execute(['id' => $id]);

        $car->images = $imgStmt->fetchAll(PDO::FETCH_COLUMN);

        return $car;
    }

    public function create(Car $car): ?Car{
       $sql = "INSERT INTO Cars (brand, model, year, pricePerDay, transmission, fuelType, seats, color, description, isAvailable) 
                VALUES (:brand, :model, :year, :pricePerDay, :transmission, :fuelType, :seats, :color, :description, :isAvailable)";

       $stmt = $this->getConnection()->prepare($sql);
      
       if ($stmt->execute([
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
        ])) {
            $car->carId = (int)$this->getConnection()->lastInsertId();
            return $car;
        }
        return null;
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