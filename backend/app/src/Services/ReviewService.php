<?php

namespace App\Services;

use App\Repositories\Interfaces\IReviewRepository;
use App\Services\Interfaces\IReviewService;
use App\Models\Review;
use Exception;

class ReviewService implements IReviewService {

    private $repository;
    public function __construct(IReviewRepository $reviewRepo) {
        $this->repository = $reviewRepo;
    }

    public function submitReview(Review $review) {
        if (empty($review->rating) || $review->rating < 1 || $review->rating > 5) {
            throw new Exception("Invalid rating. Must be between 1 and 5.");
        }

        if ($this->repository->existsByRentalId($review->rentalId)) {
            throw new Exception("You have already reviewed this booking.");
        }
        
        $review->rentalId = (int)$review->rentalId;
        $review->userId   = (int)$review->userId;
        $review->carId    = (int)$review->carId;
        $review->rating   = (int)$review->rating;
        $review->comment  = $review->comment ?? null;

        return $this->repository->create($review);
    }
}