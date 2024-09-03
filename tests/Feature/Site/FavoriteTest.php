<?php

namespace Tests\Feature\Site;

use App\Modules\Favorites\FavoriteService;
use App\Modules\Favorites\Models\Favorite;
use App\Modules\Products\Models\Sku;
use App\Modules\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Tests\TestCase;


class FavoriteTest extends TestCase
{
    use DatabaseTransactions;


    public function test_authed_user_can_add_to_favorites(): void
    {
        $user = User::inRandomOrder()->first();

        $this->seedFavorites($user->id);

        $sku = $this->getSkus(1)->first();
        $fav_data = ['id' => $sku->id];

        $response = $this->actingAs($user)
            ->postJson(route('favorites.store'), $fav_data);

        $response->assertStatus(200);
        $response->assertJson([
            'auth' => true,
            'num' => 4,
        ]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'sku_id' => $sku->id,
        ]);
    }


    public function test_guest_can_view_favorites(): void
    {
        $skus = $this->getSkus(3);
        $names = $skus->pluck('name')->toArray();
        $favorites_arr = $skus->pluck('id')->toArray();

        $response = $this->withUnencryptedCookie(FavoriteService::COOKIE, json_encode($favorites_arr))
            ->get(route('favorites'));

        $response->assertStatus(200);
        $response->assertSeeText($names);
    }


    public function test_authed_user_can_view_favorites(): void
    {
        $user = User::inRandomOrder()->first();

        $skus = $this->seedFavorites($user->id);
        $names = $skus->pluck('name')->toArray();

        $response = $this->actingAs($user)
            ->get(route('favorites'));

        $response->assertStatus(200);
        $response->assertSeeText($names);
    }


    private function getSkus(int $num): Collection
    {
        return Sku::select(
            'id',
            'name',
            'currency_id',
            'price',
            'discount',
            )
            ->inRandomOrder()
            ->limit($num)
            ->get();
    }


    private function seedFavorites(int $user_id): Collection
    {
        $skus = $this->getSkus(3);
        foreach ($skus as $sku) {
            Favorite::create([
                'sku_id' => $sku->id,
                'user_id' => $user_id,
            ]);
        }

        return $skus;
    }
}
