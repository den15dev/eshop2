<?php

namespace App\Modules\Favorites;

use App\Modules\Favorites\Models\Favorite;
use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public const COOKIE = 'fav';

    private static ?array $favorites = null;


    public static function setFavorites(?string $cookie): void
    {
        $user_id = Auth::id();

        if ($user_id) {
            $favs = Favorite::select('sku_id')
                ->where('user_id', 1)
                ->orderBy('created_at')
                ->get()
                ->pluck('sku_id')
                ->toArray();

            self::$favorites = array_values($favs);

        } elseif ($cookie) {
            self::$favorites = json_decode($cookie);

        } else {
            self::$favorites = [];
        }
    }


    public static function getFavorites(): ?array
    {
        return self::$favorites;
    }

    public static function count(): int
    {
        return self::$favorites ? count(self::$favorites) : 0;
    }

    public static function set(array $cookie_data): void
    {
        self::$favorites = $cookie_data;
    }


    public function getFavoriteSkus(): Builder
    {
        $ids = array_reverse(self::$favorites);

        return Sku::join('products', 'skus.product_id', 'products.id')
            ->joinPromos()
            ->selectForCards()
            ->whereIn('skus.id', $ids)
            ->orderByRaw(order_by_array($ids));
    }


    public function updateFavorites(int $sku_id): \stdClass
    {
        $user_id = Auth::id();

        $response = new \stdClass();
        $response->auth = (bool) $user_id;
        $response->num = null;

        if (!$user_id) return $response;

        $fav = self::$favorites;
        if (in_array($sku_id, $fav)) {
            Favorite::where('user_id', $user_id)->where('sku_id', $sku_id)->delete();
            $fav = array_filter($fav, fn($id) => $id !== $sku_id);

        } else {
            Favorite::create(['user_id' => $user_id, 'sku_id' => $sku_id]);
            $fav[] = $sku_id;
        }

        $response->num = count($fav);

        return $response;
    }


    public function moveFavoritesFromCookie(array $favs): void
    {
        if (count($favs)) {
            $user_id = Auth::id();

            foreach ($favs as $sku_id) {
                Favorite::firstOrCreate(['user_id' => $user_id, 'sku_id' => $sku_id]);
            }
        }
    }
}