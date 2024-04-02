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


    public static function fixCPUVersionAttribute(string $dir, string $filename): void
    {
        $file_ru = $dir . '/ru/' . $filename;
        $obj_ru = json_decode(file_get_contents($file_ru));
        $file_en = $dir . '/en/' . $filename;
        $obj_en = json_decode(file_get_contents($file_en));
        $file_de = $dir . '/de/' . $filename;
        $obj_de = json_decode(file_get_contents($file_de));

        if (isset($obj_ru->attributes)) {
            $attributes = $obj_ru->attributes;

            $is_changed = false;
            foreach ($attributes as $key => $attr_ru) {
                if ($attr_ru->name === 'Комплектация' || $attr_ru->name === 'Тип поставки') {
                    $variants = $attr_ru->variants;
                    $is_cpu_version = false;
                    foreach ($variants as $variant) {
                        if ($variant->name === 'BOX' || $variant->name === 'OEM') {
                            $is_cpu_version = true;
                        }
                    }

                    if ($is_cpu_version) {
                        $attr_ru->name = 'Версия';
                        $obj_en->attributes[$key]->name = 'Version';
                        $obj_de->attributes[$key]->name = 'Ausführung';
                        $is_changed = true;
                    }
                }
            }

            if ($is_changed) {
                file_put_contents($file_ru, json_encode($obj_ru, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                file_put_contents($file_en, json_encode($obj_en, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                file_put_contents($file_de, json_encode($obj_de, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }


    public static function fixManufacturerCodeSquareBrackets(string $dir, string $filename): void
    {
        $file_ru = $dir . '/ru/' . $filename;
        $obj_ru = json_decode(file_get_contents($file_ru));

        $obj_en = null;
        $file_en = $dir . '/en/' . $filename;
        if (file_exists($file_en)) {
            $obj_en = json_decode(file_get_contents($file_en));
        }

        $obj_de = null;
        $file_de = $dir . '/de/' . $filename;
        if (file_exists($file_de)) {
            $obj_de = json_decode(file_get_contents($file_de));
        }

        $is_changed = false;
        foreach ($obj_ru->specs as $key => $spec) {
            if ($spec->name === 'Код производителя') {
                $spec->value = trim($spec->value, '[]');

                if ($obj_en) {
                    $code_en = $obj_en->specs[$key]->value;
                    $obj_en->specs[$key]->value = trim($code_en, '[]');
                }

                if ($obj_de) {
                    $code_de = $obj_de->specs[$key]->value;
                    $obj_de->specs[$key]->value = trim($code_de, '[]');
                }

                $is_changed = true;
            }
        }

        if ($is_changed) {
            file_put_contents($file_ru, json_encode($obj_ru, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

            if ($obj_en) {
                file_put_contents($file_en, json_encode($obj_en, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }

            if ($obj_de) {
                file_put_contents($file_de, json_encode($obj_de, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }
}