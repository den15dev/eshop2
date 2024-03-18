<?php

namespace Database\Seeders;


class ProductTranslator
{
    public static function translateAndSave(string $dir, string $from_lang, string $to_lang, string $filename): void
    {
        $json_input = file_get_contents($dir . '/' . $from_lang . '/' . $filename);
        $obj_out = self::translateJSON($json_input, $from_lang, $to_lang, $filename);
        self::saveJSON($dir, $filename, $to_lang, $obj_out);
    }


    private static function translateJSON(string $json, string $from_lang, string $to_lang, string $filename): \stdClass
    {
        echo 'Translating ' . $filename . ' from ' . $from_lang .' to ' . $to_lang . ":\n";

        $obj_in = json_decode($json);
        $obj_out = new \stdClass();


        // Name and short description
        $name_short_descr = $obj_in->name . "\n" . $obj_in->short_descr;
        $name_short_descr_out = Translator::get($name_short_descr, $from_lang, $to_lang);
        $name_short_descr_arr = explode("\n", $name_short_descr_out);
        $obj_out->name = $name_short_descr_arr[0];
        $obj_out->short_descr = $name_short_descr_arr[1];

        echo 'Name and short description translated, sleep for ' . Translator::SLEEP . ' seconds' . "\n";
        sleep(Translator::SLEEP);


        // Description
        $obj_out->description = Translator::get($obj_in->description, $from_lang, $to_lang);

        echo 'Description translated, sleep for ' . Translator::SLEEP . ' seconds' . "\n";
        sleep(Translator::SLEEP);


        // Attributes
        if (isset($obj_in->attributes)) {
            $attributes_str_in = '';
            foreach ($obj_in->attributes as $attribute) {
                $attributes_str_in .= rtrim($attribute->name, ':') . "\n";
                foreach ($attribute->variants as $variant) {
                    $attributes_str_in .= $variant->name . "\n";
                }
                $attributes_str_in .= "\n";
            }
            $attributes_str_out = Translator::get($attributes_str_in, $from_lang, $to_lang);
            $attributes_str_out_arr = explode("\n\n", $attributes_str_out);
            $attributes_out = [];
            foreach ($obj_in->attributes as $key => $attribute) {
                $attribute_str_out_arr = explode("\n", $attributes_str_out_arr[$key]);
                $attribute_out = new \stdClass();

                $attribute_name_out = array_shift($attribute_str_out_arr);
                if ($attribute->name === 'Комплектация' && $to_lang === 'en') {
                    $attribute_out->name = 'Options';
                } else {
                    $attribute_out->name = $attribute_name_out;
                }

                $variants = [];
                foreach ($attribute->variants as $var_key => $variant) {
                    $variant_out = new \stdClass();
                    $variant_out->name = $attribute_str_out_arr[$var_key];
                    $variant_out->id = $variant->id;
                    $variant_out->is_current = $variant->is_current;
                    $variants[] = $variant_out;
                }
                $attribute_out->variants = $variants;
                $attributes_out[] = $attribute_out;
            }
            $obj_out->attributes = $attributes_out;

            echo 'Attributes translated, sleep for ' . Translator::SLEEP . ' seconds' . "\n";
            sleep(Translator::SLEEP);
        }


        // Specs
        $specs_arr_in = [];
        $specs_str_in = '';
        foreach ($obj_in->specs as $key => $spec) {
            if (strlen($specs_str_in) < 3000) {
                $specs_str_in .= $spec->name . ': ' . $spec->value;
            } else {
                $specs_arr_in[] = $specs_str_in;
                $specs_str_in = $spec->name . ': ' . $spec->value;
            }
            if ($spec->units) {
                $specs_str_in .= ' ' . $spec->units;
            }

            if ($key !== array_key_last($obj_in->specs)) {
                $specs_str_in .= "\n";
            }
        }
        if (!empty($specs_str_in)) {
            $specs_arr_in[] = $specs_str_in;
        }

        $specs_str_out = '';
        foreach ($specs_arr_in as $key => $spec_part) {
            $specs_str_out .= Translator::get($spec_part, $from_lang, $to_lang);
            if ($key !== array_key_last($specs_arr_in)) {
                $specs_str_out .= "\n";
            }
            echo 'Spec block translated (' . strlen($spec_part) . '), sleep for ' . Translator::SLEEP . ' seconds' . "\n";
            sleep(Translator::SLEEP);
        }

        $specs_str_out_arr = explode("\n", $specs_str_out);

//        file_put_contents('storage/app/data/products/computers-and-peripherals/pc-parts/motherboards/test.txt', $specs_str_out . "\n" . count($specs_str_out_arr));

        $specs_out = [];
        foreach ($obj_in->specs as $spec_key => $spec) {
            $spec_out = new \stdClass();
            $spec_row = $specs_str_out_arr[$spec_key];
            $spec_row_arr = explode(':', $spec_row);

            // Fix for color
            if (count($spec_row_arr) < 2) {
                if (str_ends_with($spec_row, 'color')) {
                    $spec_row_color_arr = explode(' ', $spec_row);
                    $spec_row_arr = ['Color', mb_strtolower($spec_row_color_arr[0])];
                }
                if (str_starts_with($spec_row, 'Farbe')) {
                    $spec_row_color_arr = explode(' ', $spec_row);
                    $spec_row_arr = ['Farbe', mb_strtolower($spec_row_color_arr[1])];
                }
            }

            // Fix for Hz
            if ($spec->units && preg_match('/^\s*(\d+)Hz$/', $spec_row_arr[array_key_last($spec_row_arr)], $matches)) {
                $spec_row_arr[array_key_last($spec_row_arr)] = $matches[1] . ' Hz';
            }

            $spec_out->name = trim($spec_row_arr[0]);
            if ($spec->units) {
                $spec_value_arr = explode(' ', trim($spec_row_arr[1]));
                $units = trim(array_pop($spec_value_arr));
                $spec_out->value = implode(' ', $spec_value_arr);
                $spec_out->units = $units;
            } else {
                $spec_out->value = trim($spec_row_arr[1]);
                $spec_out->units = null;
            }
            $specs_out[] = $spec_out;
        }
        $obj_out->specs = $specs_out;


        return $obj_out;
    }


    private static function saveJSON(string $dirname, string $filename, string $lang, \stdClass $obj): void
    {
        $out_dir = $dirname . '/' . $lang;
        if (!file_exists($out_dir)) {
            mkdir($out_dir);
        }
        $out_filename = $out_dir . '/' . $filename;
        file_put_contents($out_filename, json_encode($obj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        echo 'File saved: ' . $filename . "\n";
    }
}