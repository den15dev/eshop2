<?php

namespace App\Modules\Products;

use App\Modules\Catalog\ComparisonService;
use App\Modules\Categories\CategoryService;
use App\Modules\Favorites\FavoriteService;
use App\Modules\Products\Actions\GetAttributesAction;
use App\Modules\Products\Actions\GetSkuAction;
use App\Modules\Products\Models\Sku;
use App\Modules\Promos\PromoService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;

class ProductService
{
    /**
     * Get a collection of objects, each with 2 properties:
     * 'category_id' and 'product_count'.
     */
    public function countByCategories(): ECollection
    {
//        $categories = Product::select('category_id', DB::raw('count(*) as product_count'))->groupBy('category_id')->get();
//        $categories->firstWhere('level', 3)?->product_count;

        $product_counts = new ECollection();
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
//        $category_ids = [3, 7, 4, 20, 31, 39, 54, 61];
        $category_id = fake()->numberBetween(1, 30);
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

        $comparisonIds = ComparisonService::get()?->product_ids ?? [];
        $favoriteIds = FavoriteService::get() ?? [];

        for ($i = 0; $i < $number; $i++) {
            $product = new \stdClass();
            $product->id = $i + 1;
            $name = $names[$i % 8];
            $product->name = $name;
            $product->slug = str($name)->slug()->value();
            $product->category_slug = $category_slugs[$i % 8];
            $product->url = route('product', [$product->category_slug, $product->slug . '-' . $product->id]);
            $product->reviews_url = route('reviews', [$product->category_slug, $product->slug . '-' . $product->id]);

            $product->category_id = $category_id;
            $product->short_descr = $short_descrs[$i % 8];

            $product->discount_prc = $discounts[$i % 8];
            $product->price = $prices[$i % 8];
            if ($product->discount_prc) {
                $product->final_price = $product->price * (100 - $product->discount_prc)/100;
            } else {
                $product->final_price = $product->price;
            }

            $product->price_formatted = number_format($product->price, 0, ',', ' ') . ' &#8381;';
            $product->final_price_formatted = number_format($product->final_price, 0, ',', ' ') . ' &#8381;';

            $product->rating = $ratings[$i % 8];
            $product->vote_num = $vote_nums[$i % 8];

            $image_base = 'storage/images/products/' . (($product->id - 1) % 4 + 1) . '/01_';
            $product->image_sm = asset($image_base . '80.jpg');
            $product->image_md = asset($image_base . '230.jpg');
            $product->images = ['01', '02', '03', '04'];

            $promo_id = $promo_ids[$i % 8];
            $promo = PromoService::getActive()->firstWhere('id', $promo_id);
            $product->promo_id = $promo ? $promo_id : null;
            $product->promo_url_slug = $promo ? $promo->slug . '-' . $promo_id : null;
            $product->promo_name = $promo ? $promo->name : null;

            $product->is_comparing = in_array($product->id, $comparisonIds);
            $product->is_favorite = in_array($product->id, $favoriteIds);

            $products->push($product);
        }

        return $products;
    }


    public function getTempSpecs(): Collection
    {
        $spec_values = [
            'AMD Ryzen 5',
            '5600X',
            'AM4',
            '2020',
            'AMD Vermeer',
            'TSMC 7FF',
            '6',
            '12',
            '6',
            'нет',
            '3',
            '32',
            '3.7',
            '4.6',
            'есть',
            'DDR4',
            '128',
            '2',
            '3200',
            'нет',
            '65',
            '95',
            'есть',
            'нет',
            'PCI-E',
            '20',
        ];

        return CategoryService::getSpecs(2)->each(function ($spec, $index) use ($spec_values) {
            $pivot = new \stdClass();
            $pivot->specification_id = $index;
            $pivot->spec_value = $spec_values[$index];
            $spec->pivot = $pivot;
        });
    }


    public function getSomeProducts(int|array $ids): Collection
    {
        $tempProducts = self::getTempProducts();
        $tempNum = $tempProducts->count();

        $count = is_array($ids) ? count($ids) : $ids;

        $products = new Collection();
        for ($i = 0; $i < $count; $i++) {
            $product = $tempProducts[$i % $tempNum];
            if (is_array($ids)) {
                $product->id = $ids[$i];
                $product->url = route('product', [$product->category_slug, $product->slug . '-' . $ids[$i]]);
            }
            $products->push($product);
        }

        return $products;
    }

    public function getOneProduct(int $id): \stdClass
    {
        $tempProducts = self::getTempProducts();
        $tempNum = $tempProducts->count();
        $inner_id = ($id - 1) % $tempNum + 1;

        return $tempProducts->firstWhere('id', $inner_id);
    }


    public function getSku(int $id): Sku
    {
        return GetSkuAction::run($id);
    }


    public function getAttributes(int $product_id, int $sku_id): Collection
    {
        return GetAttributesAction::run($product_id, $sku_id);
    }


    /**
     * Explode "slug-id"-type slug to array [slug, id].
     */
    public static function parseSlug(string $slug_id): array
    {
        $slug_arr = explode('-', $slug_id);
        $id = array_pop($slug_arr);
        $slug = count($slug_arr) > 1 ? implode('-', $slug_arr) : $slug_arr[0];

        return [$slug, $id];
    }
}