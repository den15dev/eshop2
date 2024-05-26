<?php

namespace App\Admin\Products\Actions;

use App\Modules\Images\ImageService;
use App\Modules\Products\Models\Sku;
use Illuminate\Http\UploadedFile;

class UpdateSkuImagesAction
{
    public static function run(int $id, array $old_images, array $new_images, ?UploadedFile $file): void
    {
        $dir = storage_path(ImageService::LOCAL_DIR) . '/' . Sku::IMG_DIR . '/' . $id;

        // Remove unneeded images
        foreach ($old_images as $old_image) {
            if (!in_array($old_image, $new_images)) {
                foreach (Sku::IMG_SIZES as $size => $res) {
                    unlink($dir . '/' . $old_image . '_' . $size . '.jpg');
                }
            }
        }

        if ($file) {
            $new_index = 1;
            while (in_array(sprintf('%02d', $new_index), $new_images)) $new_index++;
            $new_index = sprintf('%02d', $new_index);
            $new_images[] = $new_index;

            $source_path = $file->path();

            foreach (Sku::IMG_SIZES as $size => $res) {
                $out_path = $dir . '/' . $new_index . '_' . $size . '.jpg';
                ImageService::saveToSquareFilled($source_path, $out_path, $res);
            }
        }

        Sku::firstWhere('id', $id)->update([
            'images' => count($new_images) ? $new_images : null
        ]);
    }
}