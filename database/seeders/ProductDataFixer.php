<?php

namespace Database\Seeders;

class ProductDataFixer
{
    const SPEC_UNITS = [
        'МБ', 'ГБ', 'ТБ', 'бит', 'Мбайт/сек', 'Гбайт/сек', 'об/мин',
        'Гц', 'ГГц', 'МГц', 'Мп', 'Вт', 'В', 'А', 'дБ', '°C', 'г', 'кг', 'м',
        'см', 'мм', 'л', 'ч', 'мА*ч', 'ppi', 'шт',
    ];


    public static function fixSpecUnits(string $dir, string $filename): void
    {
        // First, delete all translations
        if (file_exists($dir . '/en/' . $filename)) {
            unlink($dir . '/en/' . $filename);
        }
        if (file_exists($dir . '/de/' . $filename)) {
            unlink($dir . '/de/' . $filename);
        }

        $obj = json_decode(file_get_contents($dir . '/ru/' . $filename));

        $fixed_count = 0;
        $log = '';
        foreach ($obj->specs as $spec) {

            if ($spec->units === null) {
                $value_orig = $spec->value;
                $value_arr = explode(' ', $value_orig);
                if (count($value_arr) > 1) {
                    $units_new = array_pop($value_arr);
                    if (in_array($units_new, self::SPEC_UNITS)) {
                        $value_new = count($value_arr) > 1 ? implode(' ', $value_arr) : $value_arr[0];

                        if (!str_contains($value_new, $units_new) && count($value_arr) < 3) {
                            $spec->value = $value_new;
                            $spec->units = $units_new;
                            $log .= 'Fixed: ' . $spec->name . ': ' . $spec->value . ' (' . $spec->units . ')' . "\n";
                            $fixed_count++;
                        }
                    }
                }
            }

        }

        if ($fixed_count) {
            file_put_contents($dir . '/ru/' . $filename, json_encode($obj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

            echo $filename . "\n";
            echo $log;
        }
    }
}