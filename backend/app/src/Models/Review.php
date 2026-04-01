<?php

namespace App\Models;

class Review {
    public $reviewId;
    public $rentalId;
    public $userId;
    public $carId;
    public $rating;
    public $comment;
    public $createdAt;

    public function __construct($data = []) {
        $this->reviewId = $data['ReviewId'] ?? null;
        $this->rentalId = $data['RentalId'] ?? null;
        $this->userId   = $data['UserId'] ?? null;
        $this->carId    = $data['CarId'] ?? null;
        $this->rating   = $data['Rating'] ?? null;
        $this->comment  = $data['Comment'] ?? null;
        $this->createdAt = $data['CreatedAt'] ?? null;
    }
}