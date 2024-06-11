<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

class ProductDBSeeder
{
    private static ?string $dir = null;
    private static ?array $files = null;
    private static ?string $category_slug = null;
    private static null|int|string $category_id = null;
    const SPEC_LIMIT = 80;

    public static function run(string $dir, string $cat_slug): void
    {
        $files_ru = array_diff(scandir($dir . '/ru'), array('..', '.'));
        $files_ru_count = count($files_ru);
        $files_en = array_diff(scandir($dir . '/en'), array('..', '.'));
        $files_en_count = count($files_en);
        $files_de = array_diff(scandir($dir . '/de'), array('..', '.'));
        $files_de_count = count($files_de);

        self::$dir = $dir;
        self::$files = $files_ru;
        self::$category_slug = $cat_slug;
        self::$category_id = DB::table('categories')
            ->select('id')
            ->where('slug', $cat_slug)
            ->first()?->id;

        if ($files_ru_count) {
            if ($files_en_count >= $files_ru_count && $files_de_count >= $files_ru_count) {

                $specs = self::collectSpecs();
                self::seedSpecs($specs);

                $products = self::collectProducts();
                self::seedProducts($products);

            } else {
                echo $cat_slug . ': not all files translated' . "\n";
            }
        } else {
            echo $cat_slug . ': files not found' . "\n";
        }
    }


    private static function collectProducts(): array
    {
        $products = [];
        $taken = [];
        $files = self::$files;

        foreach ($files as $file) {

            $obj_ru = json_decode(file_get_contents(self::$dir . '/ru/' . $file));
            $obj_en = json_decode(file_get_contents(self::$dir . '/en/' . $file));
            $obj_de = json_decode(file_get_contents(self::$dir . '/de/' . $file));

            if (isset($obj_ru->attributes)) {
                $first_id = $obj_ru->attributes[0]->variants[0]->id;

                if (!in_array($obj_ru->product_id, $taken)) {
                    $product = new \stdClass();
                    $product->brand = $obj_ru->brand->name;
//                     $skus = [$obj_ru->product_id];
                    $skus = [$file];
                    $taken[] = $obj_ru->product_id;

                    foreach ($files as $child) {
                        $child_obj = json_decode(file_get_contents(self::$dir . '/ru/' . $child));

                        if (isset($child_obj->attributes)) {
                            if (!in_array($child_obj->product_id, $taken)) {
                                if ($child_obj->attributes[0]->variants[0]->id === $first_id) {
//                                      $skus[] = $child_obj->product_id;
                                    $skus[] = $child;
                                    $taken[] = $child_obj->product_id;
                                }
                            }
                        }
                    }

                    $product->skus = $skus;

                    $attributes = $obj_ru->attributes;
                    foreach ($attributes as $attr_key => $attr) {
                        $attr_name = new \stdClass();
                        $attr_name->ru = $attr->name;
                        $attr_name->en = $obj_en->attributes[$attr_key]->name;
                        $attr_name->de = $obj_de->attributes[$attr_key]->name;
                        $attr->name = $attr_name;

                        foreach ($attr->variants as $var_key => $variant) {
                            $variant_name = new \stdClass();
                            $variant_name->ru = $variant->name;
                            $variant_name->en = $obj_en->attributes[$attr_key]->variants[$var_key]->name;
                            $variant_name->de = $obj_de->attributes[$attr_key]->variants[$var_key]->name;
                            $variant->name = $variant_name;

                            unset($variant->is_current);
                        }
                    }
                    $product->attributes = $attributes;

                    $product->name = self::getProductNames($skus);

                    $products[] = $product;
                }

            } else {
                $product = new \stdClass();
                $product->brand = $obj_ru->brand->name;
//                $product->skus = [$obj_ru->product_id];
                $product->skus = [$file];
                $product->name = self::getProductNames([$file]);
                $taken[] = $obj_ru->product_id;
                $products[] = $product;
            }
        }

        // Report
        $sku_count = 0;
        foreach ($products as $key => $product) {
            // echo 'Product ' . ($key + 1) . ': ' . count($product->skus) . ' skus' . "\n";
            $sku_count += count($product->skus);
        }
        echo self::$category_slug . ': ' . count($products) . ' products found (' . $sku_count . ' SKUs)' . "\n";

        return $products;
    }


    private static function getProductNames(array $files): \stdClass
    {
        $name = new \stdClass();

        $model_names_ru = [];
        $model_names_en = [];
        $model_names_de = [];
        foreach ($files as $file) {
            $obj_ru = json_decode(file_get_contents(self::$dir . '/ru/' . $file));
            $obj_en = json_decode(file_get_contents(self::$dir . '/en/' . $file));
            $obj_de = json_decode(file_get_contents(self::$dir . '/de/' . $file));

            $model_names_ru[] = self::findSpec($obj_ru, 'Модель');
            $model_names_en[] = self::findSpec($obj_en, 'Model');
            $model_names_de[] = self::findSpec($obj_de, 'Modell');
        }

        $name->ru = self::getCommonName($model_names_ru);
        $name->en = self::getCommonName($model_names_en);
        $name->de = self::getCommonName($model_names_de);

        return $name;
    }


    private static function getCommonName(array $names): string
    {
        $name_out = '';
        if (count($names) > 1) {
            $first_name = array_shift($names);
            $first_name_arr = mb_str_split($first_name);
            $intersected = $first_name_arr;

            foreach ($names as $name_in) {
                $intersected = array_intersect_assoc($intersected, mb_str_split($name_in));
            }

            foreach ($first_name_arr as $key => $symbol) {
                if (isset($intersected[$key])) {
                    $name_out .= $symbol;
                } else {
                    $name_out .= '*';
                }
            }
        } else {
            $name_out = $names[0];
        }

        return $name_out;
    }


    private static function findSpec(\stdClass $obj, string $spec_name): string
    {
        $spec_value = '';
        foreach ($obj->specs as $spec) {
            if ($spec->name === $spec_name) {
                $spec_value = $spec->value;
                break;
            }
        }

        return $spec_value;
    }


    private static function collectSpecs(): array
    {
        $files = self::$files;
        $specs = [];

        foreach ($files as $file) {
            $obj_ru = json_decode(file_get_contents(self::$dir . '/ru/' . $file));
            $specs_ru = $obj_ru->specs;
            $obj_en = json_decode(file_get_contents(self::$dir . '/en/' . $file));
            $specs_en = $obj_en->specs;
            $obj_de = json_decode(file_get_contents(self::$dir . '/de/' . $file));
            $specs_de = $obj_de->specs;
            $count = 0;

            foreach ($specs_ru as $key => $spec_ru) {
                $is_exist = false;

                if (count($specs)) {
                    foreach ($specs as $existed_spec) {
                        if ($existed_spec->name->ru === $spec_ru->name) {
                            $is_exist = true;
                        }
                    }
                }

                if (!$is_exist) {
                    $spec = new \stdClass();

                    $spec_name = new \stdClass();
                    $spec_name->ru = $spec_ru->name;
                    $spec_name->en = $specs_en[$key]->name;
                    $spec_name->de = $specs_de[$key]->name;

                    $spec_units = null;
                    if ($spec_ru->units) {
                        $spec_units = new \stdClass();
                        $spec_units->ru = $spec_ru->units;
                        $spec_units->en = $specs_en[$key]->units;
                        $spec_units->de = $specs_de[$key]->units;
                    }

                    $spec->name = $spec_name;
                    $spec->units = $spec_units;

                    $specs[] = $spec;
                }

                $count++;
                if ($count === self::SPEC_LIMIT) break;
            }
        }

        echo self::$category_slug . ': ' . count($specs) . ' specs collected' . "\n";

        return $specs;
    }


    private static function seedSpecs(array $specs): void
    {
        $specs_seeded = 0;

        // Get last sort value
        $spec_sort_max = DB::table('specifications')
            ->where('category_id', self::$category_id)
            ->max('sort');

        $spec_sort = $spec_sort_max ? $spec_sort_max + 1 : 1;

        foreach ($specs as $spec) {
            $spec_id = DB::table('specifications')
                ->select('id')
                ->where('category_id', self::$category_id)
                ->where('name->ru', $spec->name->ru)
                ->first()?->id;

            if (!$spec_id) {
                $spec_arr = [
                    'category_id' => self::$category_id,
                    'name' => json_encode($spec->name, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                    'units' => $spec->units ? json_encode($spec->units, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null,
                    'sort' => $spec_sort,
                ];

                DB::table('specifications')->insert($spec_arr);
                $specs_seeded++;
                $spec_sort++;
            }
        }

        if ($specs_seeded) {
            echo self::$category_slug . ': ' . $specs_seeded . ' specifications added to DB' . "\n";
        } else {
            echo self::$category_slug . ': no specifications added to DB' . "\n";
        }
    }


    private static function seedProducts(array $products): void
    {
        if (count($products)) {
            $products_seeded = 0;

            foreach ($products as $product) {
                $brand_id = DB::table('brands')
                    ->select('id')
                    ->where('name', $product->brand)
                    ->first()?->id;

                if ($brand_id) {
                    $product_id = DB::table('products')
                        ->select('id')
                        ->where('name->ru', $product->name->ru)
                        ->where('category_id', self::$category_id)
                        ->where('brand_id', $brand_id)
                        ->first()?->id;

                    // Check SKU existence by their names
                    $is_skus_exist = false;
                    foreach ($product->skus as $file) {
                        $obj_ru = json_decode(file_get_contents(self::$dir . '/ru/' . $file));
                        $sku_id = DB::table('skus')
                            ->select('id')
                            ->where('name->ru', $obj_ru->name)
                            ->first()?->id;

                        if ($sku_id) {
                            $is_skus_exist = true;
                            break;
                        }
                    }

                    if (!$product_id && !$is_skus_exist) {
                        $date_time = fake()->dateTimeBetween('-3 month');
                        $product_arr = [
                            'name' => json_encode($product->name, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                            'category_id' => self::$category_id,
                            'brand_id' => $brand_id,
                            'created_at' => $date_time,
                            'updated_at' => $date_time,
                        ];

                        $product_id = DB::table('products')->insertGetId($product_arr);

                        if (isset($product->attributes)) {
                            foreach ($product->attributes as $attribute) {
                                $attribute_arr = [
                                    'name' => json_encode($attribute->name, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                                    'product_id' => $product_id,
                                    'created_at' => $date_time,
                                    'updated_at' => $date_time,
                                ];

                                $attribute_id = DB::table('attributes')->insertGetId($attribute_arr);

                                foreach ($attribute->variants as $variant) {
                                    $variant_arr = [
                                        'name' => json_encode($variant->name, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                                        'attribute_id' => $attribute_id,
                                        'created_at' => $date_time,
                                        'updated_at' => $date_time,
                                    ];

                                    $variant_id = DB::table('variants')->insertGetId($variant_arr);
                                    $variant->db_id = $variant_id;
                                }
                            }
                        }

                        $skus_seeded = 0;
                        foreach ($product->skus as $file) {
                            $obj_ru = json_decode(file_get_contents(self::$dir . '/ru/' . $file));
                            $obj_en = json_decode(file_get_contents(self::$dir . '/en/' . $file));
                            $obj_de = json_decode(file_get_contents(self::$dir . '/de/' . $file));

                            $name = new \stdClass();
                            $name->ru = $obj_ru->name;
                            $name->en = $obj_en->name;
                            $name->de = $obj_de->name;

                            $sku_code = '';
                            foreach ($obj_ru->specs as $spec) {
                                if ($spec->name === 'Код производителя') {
                                    $sku_code = trim($spec->value, '[]');
                                    break;
                                } else if ($spec->name === 'Модель') {
                                    $sku_code = $spec->value;
                                }
                            }

                            $short_descr = new \stdClass();
                            $short_descr->ru = $obj_ru->short_descr;
                            $short_descr->en = $obj_en->short_descr;
                            $short_descr->de = $obj_de->short_descr;

                            $description = new \stdClass();
                            $description->ru = $obj_ru->description;
                            $description->en = $obj_en->description;
                            $description->de = $obj_de->description;

                            $discount = fake()->randomElement([0, 0, 0, 0, 0, 0, 5, 10]);

                            $images = [];
                            foreach ($obj_ru->images as $key => $url) {
                                $images[] = $key > 8 ? $key + 1 : '0' . ($key + 1);
                            }

                            $sku_arr = [
                                'product_id' => $product_id,
                                'name' => json_encode($name, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                                'slug' => str($obj_en->name)->slug()->value(),
                                'sku' => $sku_code,
                                'short_descr' => json_encode($short_descr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                                'description' => json_encode($description, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                                'currency_id' => 'rub',
                                'price' => $obj_ru->price,
                                'images' => json_encode($images, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                                'available_from' => now(),
                                'created_at' => $date_time,
                                'updated_at' => $date_time,
                            ];

                            if ($discount) {
                                $sku_arr['discount'] = $discount;
                            }

                            $sku_id = DB::table('skus')->insertGetId($sku_arr);

                            // sku_variant
                            if (isset($product->attributes)) {
                                foreach ($product->attributes as $attr_key => $attribute) {

                                    $variant_id = 0;
                                    foreach ($attribute->variants as $var_key => $variant) {
                                        if ($obj_ru->attributes[$attr_key]->variants[$var_key]->is_current) {
                                            $variant_id = $variant->db_id;
                                        }
                                    }

                                    $sku_variant_arr = [
                                        'sku_id' => $sku_id,
                                        'variant_id' => $variant_id,
                                    ];

                                    DB::table('sku_variant')->insert($sku_variant_arr);
                                }
                            }

                            // sku_specification
                            foreach ($obj_ru->specs as $spec_key => $spec) {
                                $spec_id = DB::table('specifications')
                                    ->select('id')
                                    ->where('category_id', self::$category_id)
                                    ->where('name->ru', $spec->name)
                                    ->first()?->id;

                                if ($spec_id) {
                                    $spec_value = new \stdClass();
                                    $spec_value->ru = $spec->value;
                                    $spec_value->en = $obj_en->specs[$spec_key]->value;
                                    $spec_value->de = $obj_de->specs[$spec_key]->value;

                                    $sku_spec_arr = [
                                        'sku_id' => $sku_id,
                                        'specification_id' => $spec_id,
                                        'spec_value' => json_encode($spec_value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                                    ];

                                    DB::table('sku_specification')->insert($sku_spec_arr);
                                }
                            }

                            ImageHandler::download($obj_ru->images, self::$dir, basename($file, '.json'));
                            ImageHandler::save(self::$dir, basename($file, '.json'), $sku_id);

                            $skus_seeded++;
                        }

                        echo $skus_seeded . ' SKUs added to DB' . "\n";

                        $products_seeded++;
                    }

                } else {
                    echo 'Brand ' . $product->brand . ' not found in DB. Product ' . $product->name->ru . ' skipped.' . "\n";
                }
            }


            if ($products_seeded) {
                echo self::$category_slug . ': ' . $products_seeded . ' products added to DB' . "\n";
            } else {
                echo self::$category_slug . ': no products added to DB' . "\n";
            }

        } else {
            echo self::$category_slug . ': no products found' . "\n";
        }
    }
}