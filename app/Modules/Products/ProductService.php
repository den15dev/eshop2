<?php

namespace App\Modules\Products;

use App\Modules\Categories\CategoryService;
use App\Modules\Promos\PromoService;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    /**
     * Get a collection of objects, each with 2 properties:
     * 'category_id' and 'product_count'.
     *
     * @return Collection
     */
    public function countByCategories(): Collection
    {
//        $categories = Product::select('category_id', DB::raw('count(*) as product_count'))->groupBy('category_id')->get();
//        $categories->firstWhere('level', 3)?->product_count;

        $product_counts = new Collection();
        $categories = CategoryService::getAll();

        foreach ($categories as $category) {
            if ($category->level > 2) {
                $count = new \stdClass();
                $count->category_id = $category->id;
                $count->product_count = fake()->numberBetween(5, 300);
                $product_counts->push($count);
            }
        }

        return $product_counts;
    }


    /**
     * TEMPORARY product generator.
     *
     * @return Collection
     */
    private static function getTempProducts(): Collection
    {
        $number = 8;
        $products = new Collection();
        $discounts = [0, 5, 0, 0, 10, 0, 5, 0];
        $promo_ids = [0, 1, 0, 0, 2, 0, 0, 0];
        $prices = [550, 2490, 60490, 14490, 8190, 52350, 990, 24490];
        $names = [
            'Процессор AMD Ryzen 7 5800X3D BOX',
            'Материнская плата MSI MPG B760I EDGE WIFI DDR4',
            'Видеокарта GIGABYTE GeForce RTX 3060 Ti GAMING D6X OC',
            '2000 ГБ 2.5" SATA накопитель Crucial MX500',
            'Процессор Intel Core i9-13900 BOX',
            'Материнская плата MSI MAG B650 TOMAHAWK WIFI',
            'Видеокарта ASUS GeForce RTX 4070 Ti ROG Strix OC Edition',
            '8 ТБ Жесткий диск Seagate Exos 7E10',
        ];
        $category_ids = [3, 7, 4, 20, 31, 39, 54, 61];
        $category_slugs = [
            'cpu',
            'hdd',
            'motherboards',
            'mouses',
            'power-adapters',
            'double-door',
            'microwaves',
            '4k-uhd',
        ];
        $short_descrs = [
            'AM4, 8 x 3.4 ГГц, L2 - 4 МБ, L3 - 96 МБ, 2 штхDDR4-3200 МГц, TDP 105 Вт',
            'LGA 1700, Intel B660, 4xDDR4-3200 МГц, 2xPCI-Ex16, 3xM.2, Standard-ATX',
            'PCI-E 4.0 8 ГБ GDDR6X, 256 бит, DisplayPort x2, HDMI x2, GPU 1410 МГц',
            'SATA, чтение - 560 Мбайт/сек, запись - 510 Мбайт/сек, 3D NAND',
            'LGA 1700, 8P x 2 ГГц, 16E x 1.5 ГГц, L2 - 32 МБ, L3 - 36 МБ, 2 штхDDR4, DDR5-5600 МГц, Intel UHD Graphics 770, TDP 219 Вт',
            'AM5, AMD B650, 4xDDR5-4800 МГц, 2xPCI-Ex16, 3xM.2, Standard-ATX',
            'PCI-E 4.0 12 ГБ GDDR6X, 192 бит, DisplayPort x3, HDMI x2, GPU 2310 МГц',
            'SATA III, 6 Гбит/с, 7200 об/мин, кэш память - 256 МБ, RAID Edition',
        ];
        $ratings = [3.85, 2.15, 4.58, 4.2, 4.85, 1.25, 4.15, 3.25];
        $vote_nums = [208, 4, 26, 12, 57, 184, 12, 79];

        for ($i = 0; $i < $number; $i++) {
            $product = new \stdClass();
            $product->id = $i + 1;
            $name = $names[$i % 8];
            $product->name = $name;
            $product->slug = str($name)->slug()->value();
            $product->category_slug = $category_slugs[$i % 8];
            $product->url = route('product', [$product->category_slug, $product->slug . '-' . $product->id]);
            $product->category_id = $category_ids[$i % 8];
            $product->short_descr = $short_descrs[$i % 8];

            $product->discount_prc = $discounts[$i % 8];
            $product->price = $prices[$i % 8];
            if ($product->discount_prc) {
                $product->final_price = $product->price * (100 - $product->discount_prc)/100;
            } else {
                $product->final_price = $product->price;
            }

            $product->rating = $ratings[$i % 8];
            $product->vote_num = $vote_nums[$i % 8];

            $product->images = ['01', '02', '03', '04'];

            $promo_id = $promo_ids[$i % 8];
            $promo = PromoService::getActive()->firstWhere('id', $promo_id);
            $product->promo_id = $promo ? $promo_id : null;
            $product->promo_url_slug = $promo ? $promo->slug . '-' . $promo_id : null;
            $product->promo_name = $promo ? $promo->name : null;

            $products->push($product);
        }

        return $products;
    }


    public static function getSomeProducts(int $number): Collection
    {
        $tempProducts = self::getTempProducts();
        $tempNum = $tempProducts->count();

        $products = new Collection();
        for ($i = 0; $i < $number; $i++) {
            $products->push($tempProducts[$i % $tempNum]);
        }

        return $products;
    }

    public static function getOneProduct(int $id): \stdClass
    {
        $tempProducts = self::getTempProducts();
        $tempNum = $tempProducts->count();
        $inner_id = ($id - 1) % $tempNum + 1;

        return $tempProducts->firstWhere('id', $inner_id);
    }
}