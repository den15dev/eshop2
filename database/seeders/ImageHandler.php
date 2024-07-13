<?php

namespace Database\Seeders;

use App\Modules\Products\Models\Sku;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class ImageHandler
{
    const SLEEP = 3; // seconds
    const IMG_DIR = 'storage/app/public/images/products';


    public static function download(array $images, string $dir, string $sku_slug): void
    {
        if (!file_exists($dir . '/images')) {
            mkdir($dir . '/images');
        }

        $img_dir = $dir . '/images/' . $sku_slug;
        if (!file_exists($img_dir)) {
            mkdir($img_dir);
        }

        foreach ($images as $key => $url) {
            $prefix = sprintf('%02d', $key + 1);
            $orig_name = $prefix . '_orig.' . pathinfo($url, PATHINFO_EXTENSION);
            $orig_path = $img_dir . '/' . $orig_name;

            if (!file_exists($orig_path)) {
                echo $sku_slug . ': downloading image ' . ($key + 1) . ' ...' . "\n";

                file_put_contents($orig_path, file_get_contents($url));

                echo $sku_slug . ': image ' . ($key + 1) . ' downloaded. Sleep for ' . self::SLEEP . ' seconds' . "\n";
                sleep(self::SLEEP);
            }
        }
    }


    public static function save(string $dir, string $sku_slug, int|string $sku_id): void
    {
        $img_dir = $dir . '/images/' . $sku_slug;
        if (file_exists($img_dir)) {
            $orig_images = array_diff(scandir($img_dir), array('..', '.'));

            if (count($orig_images)) {
                $product_img_dir = self::IMG_DIR . '/' . $sku_id;
                if (!file_exists($product_img_dir)) {
                    mkdir($product_img_dir);
                }

                $saved_count = 0;
                foreach ($orig_images as $orig_img) {
                    $orig_path = $img_dir . '/' . $orig_img;
                    $prefix = explode('_', $orig_img)[0];

                    foreach (Sku::IMG_SIZES as $size => $res) {
                        $orig_size = getimagesize($orig_path);
                        $orig_width = $orig_size[0];
                        $orig_height = $orig_size[1];
                        $max = max($orig_width, $orig_height);
                        $res = min($max, $res);

                        $out_path = $product_img_dir . '/' . $prefix . '_' . $size . '.jpg';

                        if (!file_exists($out_path)) {
                            Image::load($orig_path)
                                ->fit(Manipulations::FIT_FILL, $res, $res)
                                ->background('ffffff')
                                ->format(Manipulations::FORMAT_JPG)
                                ->quality(80)
                                ->save($out_path);

                            $saved_count++;
                        }
                    }
                }

                echo $sku_slug . ': ' . $saved_count . ' images saved' . "\n";

            } else {
                echo $sku_slug . ': no images found!' . "\n";
            }
        } else {
            echo $sku_slug . ': the image folder not found!' . "\n";
        }
    }
}
