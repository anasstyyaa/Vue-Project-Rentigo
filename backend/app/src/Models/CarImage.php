<?php

namespace App\Models;

class CarImage
{
    public int $imageId;
    public int $carId;
    public string $imageUrl;
    public int $isMainImage; // using int to match tinyint(1)
    public string $uploadedAt;

    // helper to create a new CarImage instnace for insertion 
    public static function createNew(int $carId, string $imageUrl, bool $isMain = false): self
    {
        $image = new self();
        $image->carId = $carId;
        $image->imageUrl = $imageUrl;
        $image->isMainImage = $isMain ? 1 : 0;
        return $image;
    }
}