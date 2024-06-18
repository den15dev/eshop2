<?php

namespace App\Modules\Images;

use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class ImageService
{
    const JPG_QUALITY = 80;

    public static function saveToSquareCropped(string $source_path, string $out_path, int $size): void
    {
        $orig_size = getimagesize($source_path);
        $img_size = min($orig_size[0], $orig_size[1]);
        $size = min($img_size, $size);

        Image::load($source_path)
            ->fit(Manipulations::FIT_CROP, $size, $size)
            ->format(Manipulations::FORMAT_JPG)
            ->quality(self::getQuality($size))
            ->save($out_path);
    }


    public static function saveToSquareFilled(string $source_path, string $out_path, int $size): void
    {
        $orig_size = getimagesize($source_path);
        $img_size = max($orig_size[0], $orig_size[1]);
        $size = min($img_size, $size);

        Image::load($source_path)
            ->fit(Manipulations::FIT_FILL, $size, $size)
            ->background('ffffff')
            ->format(Manipulations::FORMAT_JPG)
            ->quality(self::getQuality($size))
            ->save($out_path);
    }


    private static function getQuality(int $size): int
    {
        return $size > 64 ? self::JPG_QUALITY : 95;
    }
}