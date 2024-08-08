<?php

namespace App\Modules\Users;

use App\Modules\Images\ImageService;


class UserService
{
    private static function getDir(int $user_id): string
    {
        return storage_path('app/public/images/users/' . $user_id);
    }


    public function saveImage(string $source_path, string $orig_basename, int $user_id): void
    {
        $out_dir = self::getDir($user_id);

        if (is_dir($out_dir)) {
            $old_images = array_diff(scandir($out_dir), array('..', '.'));
            foreach ($old_images as $old_image) {
                unlink($out_dir . '/' . $old_image);
            }
        } else {
            mkdir($out_dir);
        }

        $out_path = $out_dir . '/' . $orig_basename . '.jpg';
        ImageService::saveToSquareCropped($source_path, $out_path, 200);

        $thumbnail_out_path = $out_dir . '/' . $orig_basename . '_thumbnail.jpg';
        ImageService::saveToSquareCropped($source_path, $thumbnail_out_path, 38);
    }
}