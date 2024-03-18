<?php

namespace App\Modules\Favorites;

use App\Modules\Products\ProductService;
use Illuminate\Database\Eloquent\Collection;

class FavoriteService
{
    public const COOKIE = 'fav';

    private static ?array $ids = null;

    public function __construct(
        private readonly ProductService $productService
    ) {}


    public static function get(): ?array
    {
        return self::$ids;
    }

    public static function count(): int
    {
        return self::$ids ? count(self::$ids) : 0;
    }

    public static function set(array $cookie_data): void
    {
        self::$ids = $cookie_data;
    }


    public function getFavoriteProducts(): Collection
    {
        return self::$ids ? $this->productService->getSomeProducts(self::$ids) : new Collection();
    }
}