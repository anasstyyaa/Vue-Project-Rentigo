<?php 

namespace App\Services\Interfaces;

use App\Models\Review;

interface IReviewService {
    public function submitReview(Review $review);
}