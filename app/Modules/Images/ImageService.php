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
        $orig_width = $orig_size[0];
        $orig_height = $orig_size[1];
        $min = min($orig_width, $orig_height);
        $size = min($min, $size);

        $quality = $size > 64 ? self::JPG_QUALITY : 95;

        Image::load($source_path)
            ->fit(Manipulations::FIT_CROP, $size, $size)
            ->format(Manipulations::FORMAT_JPG)
            ->quality($quality)
            ->save($out_path);
    }
}