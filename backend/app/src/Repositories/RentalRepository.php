<?php

namespace App\Repositories;

use App\Framework\Repository;
use App\Models\Rental;
use App\Repositories\Interfaces\IRentalRepository;
use PDO;

class RentalRepository extends Repository implements IRentalRepository
{
    public function getByUserId(int $userId): array
    {
        $statusSql = $this->getDynamicStatusSql();
        $sql = "SELECT r.RentalId, r.UserId, r.CarId, r.StartDate, r.EndDate, 
                       r.PricePerDayAtBooking, r.TotalPrice, r.CreatedAt,
                       ($statusSql) AS Status, 
                       c.Brand, c.Model, 
                (SELECT ImageUrl FROM CarImages WHERE CarId = r.CarId LIMIT 1) as MainImage
                FROM Rentals r
                INNER JOIN Cars c ON r.CarId = c.CarId
                WHERE r.UserId = :userId
                ORDER BY r.CreatedAt DESC";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        return $this->mapRowsToModels($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getAllBookings(): array {
        $statusSql = $this->getDynamicStatusSql();
        $sql = "SELECT r.RentalId, r.UserId, r.CarId, r.StartDate, r.EndDate, 
                       r.PricePerDayAtBooking, r.TotalPrice, r.CreatedAt,
                       ($statusSql) AS Status,
                       u.FirstName, u.LastName, c.Model 
                FROM Rentals r
                JOIN Users u ON r.UserId = u.UserId
                JOIN Cars c ON r.CarId = c.CarId
                ORDER BY r.CreatedAt DESC";
                
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(Rental $rental): ?Rental
    {
        $sql = "INSERT INTO Rentals (
                    UserId, CarId, StartDate, EndDate, 
                    PricePerDayAtBooking, TotalPrice, Status
                ) VALUES (
                    :userId, :carId, :start, :end, 
                    :daily, :total, :status
                )";

        $stmt = $this->getConnection()->prepare($sql);
        $success = $stmt->execute([
            'userId' => $rental->userId,
            'carId'  => $rental->carId,
            'start'  => $rental->startDate,
            'end'    => $rental->endDate,
            'daily'  => $rental->dailyPrice,
            'total'  => $rental->totalPrice,
            'status' => $rental->status ?? 'Booked'
        ]);

        if ($success) {
            $rental->rentalId = (int)$this->getConnection()->lastInsertId();
            return $rental;
        }

        return null;
    }

    public function cancel(int $rentalId, string $reason): bool
    {
        $sql = "UPDATE Rentals 
                SET Status = 'Cancelled', 
                    CancelledAt = NOW(), 
                    CancellationReason = :reason 
                WHERE RentalId = :id";
                
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([
            'id' => $rentalId,
            'reason' => $reason
        ]);
    }

    public function isCarBooked(int $carId, string $startDate, string $endDate): bool
    {
        $sql = "SELECT COUNT(*) FROM Rentals 
                WHERE CarId = :carId 
                AND Status != 'Cancelled'
                AND CancelledAt IS NULL
                AND (StartDate < :endDate AND EndDate > :startDate)";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([
            'carId' => $carId,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);

        return (int)$stmt->fetchColumn() > 0;
    }

    private function mapRowsToModels(array $rows): array
    {
        $rentals = [];
        foreach ($rows as $row) {
            $rental = new Rental();
            $rental->rentalId = (int)$row['RentalId'];
            $rental->userId = (int)$row['UserId'];
            $rental->carId = (int)$row['CarId'];
            $rental->startDate = $row['StartDate'];
            $rental->endDate = $row['EndDate'];
            $rental->dailyPrice = (float)$row['PricePerDayAtBooking'];
            $rental->totalPrice = (float)$row['TotalPrice'];
            $rental->status = $row['Status'];

            if (isset($row['Brand'])) {
                $rental->carName = ($row['Brand'] . ' ' . $row['Model']);
            }
            if (isset($row['MainImage'])) {
                $rental->carImage = $row['MainImage'];
            }
            
            $rentals[] = $rental;
        }
        return $rentals;
    }

    private function getDynamicStatusSql(): string 
    {
        return "CASE 
                    WHEN r.Status = 'Cancelled' OR r.CancelledAt IS NOT NULL THEN 'Cancelled'
                    WHEN NOW() > r.EndDate THEN 'Completed'
                    WHEN NOW() < r.StartDate THEN 'Scheduled'
                    ELSE 'Active'
                END";
    }
}