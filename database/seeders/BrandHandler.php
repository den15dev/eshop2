<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

class BrandHandler
{
    const DIR = 'storage/app/data/brands';


    public static function updateBrands(string $dir): void
    {
        $existed = self::getExistedNames();
        $files_ru = array_diff(scandir($dir . '/ru'), array('..', '.'));
        $count_collected = 0;

        foreach ($files_ru as $file) {
            $obj = json_decode(file_get_contents($dir . '/ru/' . $file));
            $cur_name = $obj->brand->name;

            if (!in_array($cur_name, $existed)) {
                $brand = $obj->brand;
                $description = new \stdClass();
                $description->ru = '';
                $description->en = '';
                $description->de = '';
                $brand->description = $description;
                $slug = str($cur_name)->slug()->value();
                file_put_contents(self::DIR . '/' . $slug . '.json', json_encode($brand, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                echo 'Brand ' . $cur_name . ' added' . "\n";
                $count_collected++;
            }
        }

        if ($count_collected) {
            echo $count_collected . ' brands added' . "\n";
        } else {
            echo 'All brands up to date' . "\n";
        }
    }


    private static function getExistedNames(): array
    {
        $brand_names = [];
        $brand_files = array_diff(scandir(self::DIR), array('..', '.'));

        if (count($brand_files)) {
            foreach ($brand_files as $brand_file) {
                $brand_obj = json_decode(file_get_contents(self::DIR . '/' . $brand_file));
                $brand_names[] = $brand_obj->name;
            }
        }

        return $brand_names;
    }


    public static function translateBrands(): void
    {
        $brand_files = array_diff(scandir(self::DIR), array('..', '.'));

        if (count($brand_files)) {
            $count_translated = 0;

            foreach ($brand_files as $brand_file) {
                $brand_obj = json_decode(file_get_contents(self::DIR . '/' . $brand_file));
                $description_ru = $brand_obj->description->ru;
                $is_translated = false;

                if (!empty($description_ru)) {
                    if (strlen($description_ru) > 4000) {
                        echo 'The description length of ' . $brand_obj->name . ' is bigger than 4000 symbols. Translation aborted.' . "\n";
                        break;
                    }

                    if (!isset($brand_obj->description->en) || empty($brand_obj->description->en)) {
                        $description_en = Translator::get($description_ru, 'ru', 'en');
                        $brand_obj->description->en = $description_en;
                        $is_translated = true;

                        echo $brand_obj->name . ' brand description translated to en, sleep for ' . Translator::SLEEP . ' seconds' . "\n";
                        sleep(Translator::SLEEP);
                    }

                    if (!isset($brand_obj->description->de) || empty($brand_obj->description->de)) {
                        $description_de = Translator::get($brand_obj->description->en, 'en', 'de');
                        $brand_obj->description->de = $description_de;
                        $is_translated = true;

                        echo $brand_obj->name . ' brand description translated to de, sleep for ' . Translator::SLEEP . ' seconds' . "\n";
                        sleep(Translator::SLEEP);
                    }

                    if ($is_translated) {
                        file_put_contents(self::DIR . '/' . $brand_file, json_encode($brand_obj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                        echo 'File ' . $brand_file . ' saved' . "\n";
                        $count_translated++;
                    }
                }
            }

            if ($count_translated) {
                echo $count_translated . ' brands translated' . "\n";
            } else {
                echo 'All brands translated' . "\n";
            }
        }
    }


    public static function seedBrands(): void
    {
        $brand_files = array_diff(scandir(self::DIR), array('..', '.'));
        $count_seeded = 0;

        foreach ($brand_files as $brand_file) {
            $brand_slug = basename($brand_file, '.json');
            $fetched = DB::table('brands')->select('slug')->where('slug', $brand_slug)->first();

            if (!$fetched) {
                $brand_obj = json_decode(file_get_contents(self::DIR . '/' . $brand_file));
                $brand_arr = [];

                $brand_arr['name'] = $brand_obj->name;
                $brand_arr['slug'] = $brand_slug;
                $brand_arr['description'] = json_encode($brand_obj->description, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

                $date_time = fake()->dateTimeBetween('-3 month');
                $brand_arr['created_at'] = $date_time;
                $brand_arr['updated_at'] = $date_time;

                DB::table('brands')->insert($brand_arr);
                $count_seeded++;
            }
        }

        if ($count_seeded) {
            echo $count_seeded . ' brands added to DB' . "\n";
        } else {
            echo 'No brands added to DB' . "\n";
        }
    }
}