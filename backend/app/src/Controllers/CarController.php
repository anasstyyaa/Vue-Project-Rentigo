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
            if (empty($_FILES)) {
            die("DEBUG: No files were received by PHP. Check Axios or php.ini limits.");
        }

        // DEBUG LINE 2: Are there errors in the upload?
        if (isset($_FILES['images'])) {
            foreach ($_FILES['images']['error'] as $key => $error) {
                if ($error !== UPLOAD_ERR_OK) {
                    die("DEBUG: File $key has upload error code: $error (1=too big, 4=no file)");
                }
            }
        }
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
                // Pass the whole $_FILES['images'] array
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

}