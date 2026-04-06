<?php

namespace App\Services;

use App\Models\Car;
use App\Models\CarImage;
use App\Repositories\Interfaces\ICarRepository;
use App\Services\Interfaces\ICarService;

class CarService implements ICarService
{
    private ICarRepository $repository;

    public function __construct(ICarRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Car[]
     */
    public function getAll(int $page = 1, int $limit = 10): array
    {
        return $this->repository->getAll($page, $limit);
    }

    public function getById(int $id): ?Car
    {
        return $this->repository->getById($id);
    }

    public function create(Car $car): ?Car
    {
        return $this->repository->create($car);
    }

    public function update(Car $car): bool
    {
        return $this->repository->update($car);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function handleImageUploads(int $carId, array $files, bool $isUpdate = false): void
    {
        $uploadDir = '/app/public/uploads/cars/';
        $fileCount = is_array($files['name']) ? count($files['name']) : 0;

        for ($i = 0; $i < $fileCount; $i++) {

            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                error_log("Upload error for file $i: Code " . $files['error'][$i]);
                continue;
            }

            $fileName = time() . '_' . basename($files['name'][$i]);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($files['tmp_name'][$i], $targetFile)) {
                $carImage = new CarImage();
                $carImage->carId = $carId;
                $carImage->imageUrl = 'uploads/cars/' . $fileName;
                $carImage->isMainImage = ($i === 0) ? 1 : 0;

                $this->repository->addCarImage($carImage);
            } else {
                error_log("CRITICAL: Could not move file to $targetFile. Check folder permissions!");
            }
        }
    }

    public function addCarImage(CarImage $image): bool 
    {
        return $this->repository->addCarImage($image);
    }

    public function setMainImage(int $carId, string $url): bool {
        return $this->repository->setMainImage($carId, $url);
    }

    public function deleteImageByUrl(string $url): bool {
        return $this->repository->deleteImageByUrl($url);
    }
}