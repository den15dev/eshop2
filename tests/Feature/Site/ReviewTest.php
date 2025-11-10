<?php

namespace Tests\Feature\Site;

use App\Modules\Products\Models\Sku;
use App\Modules\Reviews\Enums\TermOfUse;
use App\Modules\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use DatabaseTransactions;


    public function test_review_page_with_reviews(): void
    {
        $sku = $this->getSku();

        $user_ids = $sku->reviews()->pluck('user_id')->toArray();
        $user_names = User::select('name')
            ->whereIn('id', $user_ids)
            ->pluck('name')
            ->toArray();

        $response = $this->get($sku->reviews_url);

        $response->assertStatus(200);
        $response->assertSeeText($user_names);
    }


    public function test_review_page_without_reviews(): void
    {
        $sku = $this->getSku(without_reviews: true);

        $response = $this->get($sku->reviews_url);

        $response->assertStatus(200);
        $response->assertSeeText(__('reviews.no_reviews'));
    }


    public function test_adding_a_review_and_updating_sku_rating(): void
    {
        $sku = $this->getSku();
        $author_ids = $sku->reviews()->pluck('user_id')->toArray();
        $user = User::whereNotIn('id', $author_ids)->first();

        $review_data = [
            'mark' => 4,
            'sku_id' => $sku->id,
            'term' => TermOfUse::Weeks->value,
            'pros' => fake()->realText(rand(20, 50)),
            'cons' => fake()->realText(rand(20, 50)),
            'comnt' => fake()->realText(rand(20, 50)),
        ];

        $response = $this->followingRedirects()
            ->actingAs($user)
            ->from($sku->reviews_url)
            ->post($sku->reviews_url, $review_data);

        $this->assertDatabaseHas('reviews', $review_data);

        $vote_num = $sku->reviews()->count();
        $marks = $sku->reviews()->pluck('mark')->toArray();
        $rating = number_format(array_sum($marks) / count($marks), 2);
        $this->assertDatabaseHas('skus', [
            'id' => $sku->id,
            'rating' => $rating,
            'vote_num' => $vote_num,
        ]);

        $response->assertStatus(200);
        $response->assertSeeText(__('reviews.review_added'));
    }


    public function test_only_authed_users_can_add_a_review(): void
    {
        $sku = $this->getSku();

        $response = $this->get($sku->reviews_url);

        $response->assertStatus(200);
        $response->assertSeeText(__('reviews.sign_in_to_review'));
        $response->assertDontSee('reviews-form');

        $author_ids = $sku->reviews()->pluck('user_id')->toArray();
        $user = User::whereNotIn('id', $author_ids)->first();

        $response = $this->actingAs($user)->get($sku->reviews_url);
        $response->assertStatus(200);
        $response->assertSee('reviews-form');
    }


    public function test_user_can_not_add_more_than_one_review(): void
    {
        $sku = $this->getSku();

        $author_ids = $sku->reviews()->pluck('user_id')->toArray();
        $author = User::where('id', $author_ids[0])->first();

        $response = $this->actingAs($author)->get($sku->reviews_url);
        $response->assertStatus(200);
        $response->assertSee(__('reviews.already_reviewed'));
    }


    private function getSku($without_reviews = false): Sku
    {
        $sku = Sku::join('products', 'products.id', 'skus.product_id')
            ->join('categories', 'categories.id', 'products.category_id')
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'skus.code',
                'categories.slug as category_slug',
            );

        $sku = $without_reviews
            ? $sku->whereDoesntHave('reviews')
            : $sku->whereHas('reviews');

        return $sku->inRandomOrder()->first();
    }
}
