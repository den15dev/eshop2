<?php

namespace App\Modules\Products;

use App\Modules\Brands\Models\Brand;
use App\Modules\Products\Actions\GetAttributesAction;
use App\Modules\Products\Actions\GetSkuAction;
use App\Modules\Products\Models\Sku;
use App\Modules\Settings\SettingService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function getSku(int $id): ?Sku
    {
        return GetSkuAction::run($id);
    }


    public function getAttributes(int $product_id, int $sku_id): Collection
    {
        return GetAttributesAction::run($product_id, $sku_id);
    }


    public function getBrand(int $product_id): Brand
    {
        return Brand::join('products', 'brands.id', 'products.brand_id')
            ->select(
                'brands.id',
                'brands.name',
                'brands.slug',
            )
            ->firstWhere('products.id', $product_id);
    }


    public function getDiscounted()
    {
        return Sku::getCards()
            ->orderByDesc(DB::raw(Sku::DISCOUNT))
            ->orderByDesc('skus.created_at')
            ->limit(SettingService::get('carousel_items_num'))
            ->get();
    }

    public function getLatest()
    {
        return Sku::getCards()
            ->orderByDesc('skus.created_at')
            ->limit(SettingService::get('carousel_items_num'))
            ->get();
    }

    public function getPopular()
    {
        return Sku::getCards()
            ->orderByRaw('skus.rating IS NULL, skus.rating DESC')
            ->orderByDesc('skus.vote_num')
            ->limit(SettingService::get('carousel_items_num'))
            ->get();
    }


    /**
     * Explode "slug-id"-type slug to array [slug, id].
     */
    public static function parseSlug(string $slug_id): array|bool
    {
        $slug_arr = explode('-', $slug_id);
        if (count($slug_arr) < 2) return false;

        $id = array_pop($slug_arr);
        if (!ctype_digit($id)) return false;

        $slug = count($slug_arr) > 1 ? implode('-', $slug_arr) : $slug_arr[0];

        return [$slug, $id];
    }
}
