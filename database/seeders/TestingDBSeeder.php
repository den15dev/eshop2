<?php

namespace Database\Seeders;

use App\Modules\Brands\Models\Brand;
use App\Modules\Categories\Models\Category;
use App\Modules\Categories\Models\Specification;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Attribute;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Sku;
use App\Modules\Products\Models\Variant;
use App\Modules\Reviews\Models\Reaction;
use App\Modules\Reviews\Models\Review;
use App\Modules\Users\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TestingDBSeeder extends Seeder
{
    use WithoutModelEvents;


    public function run(): void
    {
        $cat_id = 3;
        $category = Category::on(config('database.testing'))->firstWhere('id', $cat_id);
        $spec_num = Specification::on(config('database.testing'))
            ->where('category_id', $cat_id)
            ->count();

        User::newFactory()
            ->connection(config('database.testing'))
            ->count(10)
            ->create();

        Brand::newFactory()
            ->connection(config('database.testing'))
            ->count(5)
            ->create();

        Specification::newFactory()
            ->connection(config('database.testing'))
            ->count(20)
            ->for($category)
            ->sequence(fn (Sequence $sequence) => ['sort' => $spec_num + $sequence->index + 1])
            ->create();

        Product::newFactory()
            ->connection(config('database.testing'))
            ->count(5)
            ->for($category)
            ->state(fn() => [
                'brand_id' => Brand::on(config('database.testing'))
                    ->inRandomOrder()
                    ->first()
                    ->id
            ])

            ->has(
                Sku::newFactory()
                    ->connection(config('database.testing'))
                    ->count(2)
                    ->state(fn() => [
                        'currency_id' => Currency::on(config('database.testing'))
                            ->inRandomOrder()
                            ->first()
                            ->id
                    ])
                    ->has(
                        Review::newFactory()
                            ->connection(config('database.testing'))
                            ->count(3)
                            ->state(fn() => [
                                'user_id' => User::on(config('database.testing'))
                                    ->inRandomOrder()
                                    ->first()
                                    ->id
                            ])
                            ->has(
                                Reaction::newFactory()
                                    ->connection(config('database.testing'))
                                    ->count(4)
                                    ->state(fn() => [
                                        'user_id' => User::on(config('database.testing'))
                                            ->inRandomOrder()
                                            ->first()
                                            ->id
                                    ])
                            )
                    )
            )

            ->has(
                Sku::newFactory()
                    ->connection(config('database.testing'))
                    ->count(2)
                    ->state(fn() => [
                        'currency_id' => Currency::on(config('database.testing'))
                            ->inRandomOrder()
                            ->first()
                            ->id
                    ])
            )

            ->has(
                Attribute::newFactory()
                    ->connection(config('database.testing'))
                    ->count(2)
                    ->has(
                        Variant::newFactory()
                            ->connection(config('database.testing'))
                            ->count(2)
                    )
            )
            ->create();

        self::linkSkuVariants();
        self::linkSkuSpecifications();
    }


    private static function linkSkuVariants(): void
    {
        $products = Product::on(config('database.testing'))
            ->select('id')
            ->with('attributes.variants:id,attribute_id')
            ->with('skus:id,product_id')
            ->get();

        foreach ($products as $product) {
            $sku_variants = self::getSkuVariants($product->attributes);

            foreach ($product->skus as $key => $sku) {
                if (isset($sku_variants[$key])) {
                    foreach ($sku_variants[$key] as $variant_id) {
                        DB::connection(config('database.testing'))
                            ->table('sku_variant')
                            ->insert([
                                'sku_id' => $sku->id,
                                'variant_id' => $variant_id,
                            ]);
                    }
                }
            }

        }
    }


    private static function getSkuVariants(Collection $attributes, array $combinations = []): array
    {
        static $key = 0;
        static $combination = [];

        if (isset($attributes[$key])) {
            foreach ($attributes[$key]->variants as $variant) {
                $combination[] = $variant->id;

                if (isset($attributes[$key + 1])) {
                    $key++;
                    $combinations = self::getSkuVariants($attributes, $combinations);
                    $key--;
                } else {
                    $combinations[] = $combination;
                }

                array_pop($combination);
            }
        }

        return $combinations;
    }


    private static function linkSkuSpecifications(): void
    {
        $languages = LanguageService::getAll();

        $skus = Sku::on(config('database.testing'))
            ->join('products', 'products.id', 'skus.product_id')
            ->join('categories', 'categories.id', 'products.category_id')
            ->select(
                'skus.id',
                'categories.id as category_id',
            )
            ->get();

        foreach ($skus as $sku) {
            $specs = Specification::on(config('database.testing'))
                ->select('id', 'name')
                ->where('category_id', $sku->category_id)
                ->get();

            foreach ($specs as $spec) {
                $spec_value = [];
                foreach ($languages as $lang) {
                    $spec_value[$lang->id] = fake()->words(fake()->numberBetween(1, 3), true);
                }

                $sku->specifications()->attach($spec->id, ['spec_value' => $spec_value]);
            }
        }
    }


    private static function removeSelfReactions(): void
    {
        $reviews = Review::on(config('database.testing'))
            ->select('id', 'user_id')
            ->get();

        foreach ($reviews as $review) {
            $author_id = $review->user_id;
            $review->reactions()->each(function ($reaction) use ($author_id) {
                if ($reaction->user_id === $author_id) {
                    $reaction->delete();
                }
            });
        }
    }
}
