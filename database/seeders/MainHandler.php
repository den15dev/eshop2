<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Cache;

class MainHandler
{
    const DATA_DIR = 'storage/app/data/products';
    const CATEGORIES = 'app/Modules/Categories/Data/categories.php';


    public static function run(?string $category_slug): void
    {
        $start_time = time();

        BrandHandler::translateBrands();
        BrandHandler::seedBrands();

        $categories = require_once self::CATEGORIES;
        $translated_num = self::handleData($categories, $category_slug);

        Cache::forget('categories');
        echo 'Categories\' cache has been cleared to update skus count' . "\n";

        if (!$translated_num) {
            echo 'All files translated' . "\n";
        } else {
            echo 'Elapsed: ' . self::getTimeStr(time() - $start_time) . "\n";
        }
    }


    private static function handleData(array $categories, ?string $category_slug, int $translation_limit = 0): int
    {
        static $translation_count = 0;
        static $level = 1;
        static $dir = self::DATA_DIR;

        foreach ($categories as $cat) {
            $dir .= '/' . $cat['slug'];

            if (isset($cat['subcategories'])) {
                $level++;

                self::handleData($cat['subcategories'], $category_slug, $translation_limit);

                $level--;
            } else {
                $dir_ru = $dir . '/ru';
                if (file_exists($dir_ru) && is_dir($dir_ru) && (!$category_slug || $category_slug === $cat['slug'])) {

                    $files = array_diff(scandir($dir_ru), array('..', '.'));

                    $dir_en = $dir . '/en';
                    $dir_de = $dir . '/de';
                    if (!file_exists($dir_en)) {
                        mkdir($dir_en);
                    }
                    if (!file_exists($dir_de)) {
                        mkdir($dir_de);
                    }

                    foreach ($files as $filename) {
                        if ($translation_count < $translation_limit || $translation_limit === 0) {
                            $is_counted = false;
                            // Translate
                            if (!file_exists($dir_en . '/' . $filename)) {
                                ProductTranslator::translateAndSave($dir, 'ru', 'en', $filename);
                                ProductTranslator::translateAndSave($dir, 'en', 'de', $filename);
                                $is_counted = true;
                            }

                            // Fix spec units (deletes all translations!)
                            // ProductDataFixer::fixSpecUnits($dir, $filename);

                            // Fix Version attribute (BOX, OEM) in CPUs
                            // ProductDataFixer::fixCPUVersionAttribute($dir, $filename);

                            // Fix square bracket in Manufacturer code
                            // ProductDataFixer::fixManufacturerCodeSquareBrackets($dir, $filename);

                            if ($is_counted) {
                                $translation_count++;
                                echo 'Total handled: ' . $translation_count . "\n";
                            }

                        } else {
                            break;
                        }
                    }

                    BrandHandler::updateBrands($dir);

                    ProductDBSeeder::run($dir, $cat['slug']);
                }
            }

            $dir = substr($dir, 0, -1 * strlen('/' . $cat['slug']));
        }

        return $translation_count;
    }


    private static function getTimeStr(int $seconds): string
    {
        $min = intval(floor($seconds / 60));
        $min_str = $min > 9 ? $min : '0' . $min;
        $sec = $seconds % 60;
        $sec_str = $sec > 9 ? $sec : '0' . $sec;
        $hours = intval(floor($min / 60));

        return $hours . ':' . $min_str . ':' . $sec_str;
    }
}
