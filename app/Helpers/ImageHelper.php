<?php namespace App\Helpers;

use App\Constants\ImagePaths;
use Illuminate\Support\Facades\File;

class ImageHelper
{
    public static function generateBrandLogoName($brand)
    {
        return $brand->id . ImagePaths::EXTENSION;
    }

    public static function getCarImages($car)
    {
        $folderPath = storage_path('app/public/uploads/images/cars/' . $car->id);

        if (!File::exists($folderPath)) {
            return [];
        }

        $files = File::files($folderPath);

        $imageUrls = [];

        foreach ($files as $file) {
            $imageUrls[] = asset('storage/uploads/images/cars/' . $car->id . '/' . $file->getFilename());
        }

        return $imageUrls;
    }


    public static function getFirstCarImage($car): string
    {
        $images = self::getCarImages($car);

        if ($images && count($images) > 0) {
            return $images[0];
        }
        return asset('images/no-image.png');
    }
}
