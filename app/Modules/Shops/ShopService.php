<?php

namespace App\Modules\Shops;

use App\Modules\Shops\Actions\GetOpeningHoursForHumanAction;
use App\Modules\Shops\Models\Shop;
use Illuminate\Support\Collection;

class ShopService
{
    public function getAll(): Collection
    {
        return Shop::orderBy('sort')->get();
    }


    public function getShopsForCart(): Collection
    {
        return Shop::select(['id', 'address', 'sort'])
            ->orderBy('sort')
            ->get();
    }


    public static function getOpeningHoursForHuman(array $opening_hours): array
    {
        return GetOpeningHoursForHumanAction::run($opening_hours);
    }


    public function getJSON(Collection $shops): string
    {
        $shops_data = [];
        foreach ($shops as $shop) {
            $shops_data[] = [
                $shop->id,
                [$shop->name, $shop->address, $shop->opening_hours_human->implode('<br>')],
                $shop->location,
            ];
        }

        return json_encode($shops_data, JSON_UNESCAPED_UNICODE);
    }
}