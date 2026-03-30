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
        $sql = "SELECT r.*, c.Brand, c.Model, 
                (SELECT ImageUrl FROM CarImages WHERE CarId = r.CarId LIMIT 1) as MainImage
                FROM Rentals r
                INNER JOIN Cars c ON r.CarId = c.CarId
                WHERE r.UserId = :userId
                ORDER BY r.CreatedAt DESC";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        return $this->mapRowsToModels($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getAll(): array
    {
        $sql = "SELECT r.*, c.Brand, c.Model, u.FirstName, u.LastName 
                FROM Rentals r
                JOIN Cars c ON r.CarId = c.CarId
                JOIN users u ON r.UserId = u.UserId
                ORDER BY r.CreatedAt DESC";

        $stmt = $this->getConnection()->query($sql);
        return $this->mapRowsToModels($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function create(Rental $rental): ?Rental
    {
        $sql = "INSERT INTO rentals (
                    UserId, CarId, StartDate, EndDate, 
                    PricePerDayAtBooking, TotalPrice, Status
                ) VALUES (
                    :userId, :carId, :start, :end, 
                    :daily, :total, :status
                )";

        $stmt = $this->getConnection()->prepare($sql);
        $success = $stmt->execute([
            'userId' => $rental->setUserId('userId'),
            'carId'  => $rental->setCarId('carId'),
            'start'  => $rental->setStartDate('startDate'),
            'end'    => $rental->setEndDate('endDate'),
            'daily'  => $rental->setDailyPrice('dailyPrice'),
            'total'  => $rental->setTotalPrice('totalPrice'),
            'status' => $rental->setStatus('status') ?? 'Booked'
        ]);

        if ($success) {
            $rental->setRentalId((int)$this->getConnection()->lastInsertId());
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
            $rental->setRentalId((int)$row['RentalId']);
            $rental->setUserId((int)$row['UserId']);
            $rental->setCarId((int)$row['CarId']);
            $rental->setStartDate($row['StartDate']);
            $rental->setEndDate($row['EndDate']);
            $rental->setDailyPrice((float)$row['PricePerDayAtBooking']);
            $rental->setTotalPrice((float)$row['TotalPrice']);
            $rental->setStatus($row['Status']);

            if (isset($row['Brand'])) {
                $rental->setCarName($row['Brand'] . ' ' . $row['Model']);
            }
            if (isset($row['MainImage'])) {
                $rental->setCarImage($row['MainImage']);
            }
            
            $rentals[] = $rental;
        }
        return $rentals;
    }
}