<?php

namespace App\Modules\Products;

use App\Modules\Products\Actions\GetAttributesAction;
use App\Modules\Products\Actions\GetSkuAction;
use App\Modules\Products\Models\Sku;
use Illuminate\Support\Collection;

class ProductService
{
    private const HOME_CAROUSEL_LIMIT = 10;


    public function getSku(int $id): Sku
    {
        return GetSkuAction::run($id);
    }


    public function getAttributes(int $product_id, int $sku_id): Collection
    {
        return GetAttributesAction::run($product_id, $sku_id);
    }


    public function getDiscounted()
    {
        return Sku::getCards()
            ->orderByDesc('skus.discount')
            ->orderByDesc('skus.created_at')
            ->limit(self::HOME_CAROUSEL_LIMIT)
            ->get();
    }

    public function getLatest()
    {
        return Sku::getCards()
            ->orderByDesc('skus.created_at')
            ->limit(self::HOME_CAROUSEL_LIMIT)
            ->get();
    }

    public function getPopular()
    {
        return Sku::getCards()
            ->orderByRaw('skus.rating IS NULL, skus.rating DESC')
            ->orderByDesc('skus.vote_num')
            ->limit(self::HOME_CAROUSEL_LIMIT)
            ->get();
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