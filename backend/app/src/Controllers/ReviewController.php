<?php

namespace App\Controllers;

use App\Services\Interfaces\IReviewService;
use App\Services\Interfaces\IAuthService;
use App\Models\Review;
use Exception;
use App\Framework\Controller;

class ReviewController extends Controller {
    private IReviewService $service;

    public function __construct(IReviewService $service, IAuthService $authService) {
        parent::__construct($authService);
        $this->service = $service;
    }

    public function handlePost() {
        try {
            $user = $this->getAuthenticatedUser();

            /** @var Review $review */
            $review = $this->mapPostDataToClass(Review::class);
            $review->userId = $user->userId;
            $savedReview = $this->service->submitReview($review);
            
            return $this->sendSuccessResponse([
                'message' => 'Review submitted successfully!',
                'reviewId' => $savedReview->reviewId
            ], 201);
        } catch (Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 400);
        }
    }
}