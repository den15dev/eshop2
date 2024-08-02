<?php

use Illuminate\Support\Facades\Route;


if (!function_exists('active_link')) {
    /**
     * Appends css class name for active navigation items, according to route name.
     *
     * @param string $name - route name.
     * @param string $css_class - css class name, default is "active".
     * @return string
     */
    function active_link(string $name, string $css_class = 'active'): string
    {
        $routes = [$name, $name . '.create', $name . '.edit'];

        $aliases = [
            'skus' => 'products',
        ];

        $class = Route::is($routes) ? $css_class : '';

        if (empty($class)) {
            foreach ($aliases as $alias => $route) {
                if (str_ends_with($name, $route)) {
                    $name = str_replace($route, $alias, $name);
                    $routes = [$name, $name . '.create', $name . '.edit'];
                    $class = Route::is($routes) ? $css_class : '';
                }
            }
        }

        return $class;
    }
}


if (!function_exists('order_by_array')) {
    function order_by_array(?array $arr): string
    {
        if (!$arr || !count($arr)) return '';

        return match (env('DB_CONNECTION')) {
            'pgsql' => 'ARRAY_POSITION(ARRAY[' . implode(', ', $arr) . '], skus.id)',
            'mysql' => 'FIELD(skus.id, ' . implode(', ', $arr) . ')',
            default => '',
        };
    }
}


if (!function_exists('parse_slug')) {
    /**
     * Explodes "slug-id"-type slug to array [slug, id].
     *
     * @param string $slug_id - incoming "slug-id"-type slug.
     * @return array - like [slug, id].
     */
    function parse_slug(string $slug_id): array
    {
        $slug_arr = explode('-', $slug_id);
        $id = intval($slug_arr[count($slug_arr) - 1]);
        array_pop($slug_arr);
        $slug = implode('-', $slug_arr);

        return [$slug, $id];
    }
}



if (!function_exists('format_price')) {
    /**
     * Removes trailing zeros in decimal part and inserts space thousands separator.
     *
     * @param string $bcmath_price
     * @return string
     */
    function format_price(string|null $bcmath_price): string
    {
        if ($bcmath_price !== null) {
            if (preg_match('/\.0+$/', $bcmath_price)) {
                $bcmath_price = explode('.', $bcmath_price)[0];
            }
            return preg_replace('/(\d)(?=(\d\d\d)+(?!\d))/', '$1 ', $bcmath_price);
        }
        return '';
    }
}


if (!function_exists('parse_price')) {
    /**
     * Parses price from user input. Removes spaces, replaces comma, etc.
     *
     * @param string|null $input_price
     * @return string|null
     */
    function parse_price(string|null $input_price): string|null
    {
        $price = null;
        if ($input_price !== null) {
            $price = str_replace(',', '.', $input_price);
            $price = str_replace(' ', '', $price);
            $price_arr = explode('.', $price);
            $price_arr[0] = intval($price_arr[0]);
            $price = $price_arr[0];

            if (count($price_arr) > 1) {
                $price_arr = array_slice($price_arr, 0, 2);
                $price_arr[1] = intval(substr($price_arr[1], 0, 2));
                if ($price_arr[1] > 0) $price = implode('.', $price_arr);
            }
        }

        return $price;
    }
}


if (!function_exists('get_image')) {
    /**
     * Looks if an image exists, if it doesn't, returns a placeholder or null.
     *
     * @param $short_path - a part of a path after the '.../images/',
     *                      for example: 'brands/amd.svg'.
     */

    function get_image(string $short_path, string $placeholder_size): ?string
    {
        $full_path = config('filesystems.disks.images.root') . '/' . $short_path;
        $relative_url = config('filesystems.disks.images.relative_url') . '/' . $short_path;

        if (file_exists($full_path)) {
            return asset($relative_url);
        }

        return asset('img/default/no-image_' . $placeholder_size . '.jpg');
    }
}


if (!function_exists('to_paragraphs')) {
    /**
     * Divides text to paragraphs replacing line breaks.
     *
     * @param string $text
     * @return string
     */
    function to_paragraphs(string $text): string
    {
        $tags = '</p>' . "\n" . '<p>';
        $text = str_replace(["\r\n","\r","\n","\\r","\\n","\\r\\n"], $tags, $text);
        return '<p>' . $text . '</p>';
    }
}


if (!function_exists('camel_case')) {
    /**
     * Converts snake_case to camelCase.
     *
     * @param string $snake_case
     * @return string
     */
    function camel_case(string $snake_case): string
    {
        if ($snake_case) {
            $snake_case_arr = explode('_', $snake_case);
            for ($i = 0; $i < count($snake_case_arr); $i++) {
                if ($i > 0) {
                    $snake_case_arr[$i] = ucfirst($snake_case_arr[$i]);
                }
            }
            return implode($snake_case_arr);
        }

        return '';
    }
}


if (!function_exists('parse_comma_list')) {
    /**
     * Parses a list with commas and dashes, like '3,45,48-52,59', into an array.
     *
     * @param string|null $comma_list
     * @return array|null
     */
    function parse_comma_list(?string $comma_list): ?array
    {
        $out_arr = [];
        if ($comma_list) {
            $id_arr = explode(',', trim($comma_list));

            foreach ($id_arr as $id_item) {
                $id_item = trim($id_item);
                $id_item_arr = explode('-', $id_item);
                if (count($id_item_arr) > 1) {
                    $start_id = intval(trim($id_item_arr[0]));
                    $end_id = intval(trim($id_item_arr[1]));
                    for ($i = $start_id; $i <= $end_id; $i++) {
                        array_push($out_arr, $i);
                    }
                } else {
                    if (preg_match('/^\d+$/', $id_item)) {
                        array_push($out_arr, intval($id_item));
                    }
                }
            }
        }

        return $out_arr ?: null;
    }
}


if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst(string $str): string
    {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc.mb_substr($str, 1);
    }
}


function isValidTimezoneId(?string $timezone_id): bool
{
    if (!$timezone_id) return false;

    $valid = array();
    $tza = timezone_abbreviations_list();
    foreach ($tza as $zone)
    {
        foreach ($zone as $item)
        {
            $valid[$item['timezone_id']] = true;
        }
    }
    unset($valid['']);

    return isset($valid[$timezone_id]);
}
