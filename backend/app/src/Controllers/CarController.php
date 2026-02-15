<?php

namespace App\Controllers; 

use App\Models\Car;
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

    public function update(int $id){
        try {
            $car = $this->mapPostDataToClass(Car::class);
            $car->carId = $id;
            $updatedCar = $this->carService->update($car);
            return $this->sendSuccessResponse($updatedCar);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
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