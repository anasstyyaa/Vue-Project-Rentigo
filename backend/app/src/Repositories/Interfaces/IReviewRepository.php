<?php

namespace App\Repositories\Interfaces;

use App\Models\Review;

interface IReviewRepository {
    public function create(Review $review): ? Review; 
    public function existsByRentalId($rentalId);
}