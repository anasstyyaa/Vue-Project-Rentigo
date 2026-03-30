<?php

namespace App\Controllers; 

use App\Models\Car;
use App\Models\CarImage;
use App\Services\Interfaces\ICarService;
use App\Framework\Controller;

class CarController extends Controller
{
    private ICarService $carService;

    public function __construct(ICarService $carService)
    {

        $this->carService = $carService;
    }

    public function getAll(){
        try {
            $cars = $this->carService->getAll();
            return $this->sendSuccessResponse($cars);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function get(int $id){
        try {
            $car = $this->carService->getById($id);

            if (!$car) {
                return $this->sendErrorResponse('Car not found', 404);
            }

            return $this->sendSuccessResponse($car);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function create(){
        try{
            $car = $this->mapPostDataToClass(Car::class);
            $createdCar = $this->carService->create($car);
            return $this->sendSuccessResponse($createdCar, 201);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function update(int $id) 
    {
        try {
            $car = $this->carService->getById($id);

            if (!$car) {
                return $this->sendErrorResponse('Car not found', 404);
            }

            $fields = ['brand', 'model', 'year', 'pricePerDay', 'transmission', 'fuelType', 'seats', 'isAvailable', 'color', 'description'];
            foreach ($fields as $field) {
                if (isset($_POST[$field])) {
                    $car->$field = $_POST[$field];
                }
            }

            if (!empty($_FILES['images'])) {
                $this->carService->handleImageUploads($car->carId, $_FILES['images']);
            }

            $success = $this->carService->update($car);

            return $success 
                ? $this->sendSuccessResponse($car) 
                : $this->sendErrorResponse('Failed to update car', 500);

        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function delete(int $id){
        try {
            $deleted = $this->carService->delete($id);
            if ($deleted) {
                return $this->sendSuccessResponse(null, 204);
            } else {
                return $this->sendErrorResponse('Car not found', 404);
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function deleteImage() {
        $data = json_decode(file_get_contents('php://input'), true);
        $imageUrl = $data['imageUrl'] ?? null;

        if ($imageUrl) {
            $this->carService->deleteImageByUrl($imageUrl);

            $filePath = __DIR__ . '/../../public/' . $imageUrl;
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            echo json_encode(['success' => true]);
        }
    }

    public function setMain() {
        $data = json_decode(file_get_contents('php://input'), true);
        $carId = $data['carId'] ?? null;
        $url = $data['imageUrl'] ?? null;

        if ($carId && $url) {
            $success = $this->carService->setMainImage((int)$carId, $url);
            echo json_encode(['success' => $success]);
            return;
        }
        http_response_code(400);
        echo json_encode(['error' => 'Missing data']);
    }
}