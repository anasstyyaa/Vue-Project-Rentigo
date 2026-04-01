<?php

namespace App\Repositories;

use App\Models\Review;
use App\Framework\Repository;
use App\Repositories\Interfaces\IReviewRepository;

use PDO;

class ReviewRepository extends Repository implements IReviewRepository {

    public function create(Review $review): ? Review {
        $sql = "INSERT INTO Reviews (RentalId, UserId, CarId, Rating, Comment, CreatedAt) 
                VALUES (:rentalId, :userId, :carId, :rating, :comment, NOW())";
        
        $stmt = $this->getConnection()->prepare($sql);
        $success = $stmt->execute([
            ':rentalId' => $review->rentalId,
            ':userId'   => $review->userId,
            ':carId'    => $review->carId,
            ':rating'   => $review->rating,
            ':comment'  => $review->comment
        ]);
        
        if ($success) {
            $review->reviewId = (int)$this->getConnection()->lastInsertId();
            return $review;
        }

        return null;

    }

    public function existsByRentalId($rentalId) {
        $stmt = $this->getConnection()->prepare("SELECT COUNT(*) FROM Reviews WHERE RentalId = ?");
        $stmt->execute([$rentalId]);
        return $stmt->fetchColumn() > 0;
    }
}