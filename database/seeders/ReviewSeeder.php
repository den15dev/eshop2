<?php

namespace Database\Seeders;

use App\Modules\Products\Models\Sku;
use App\Modules\Reviews\Models\Reaction;
use App\Modules\Reviews\Models\Review;
use App\Modules\Reviews\ReviewService;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    const REVIEWS_NUM = 100;
    const REACTIONS_MAX_NUM = 5; // Per one review


    public function __construct(
        private readonly ReviewService $reviewService,
    ){}


    public function run(): void
    {
        $user_ids = User::where('email', 'like', '%' . UserSeeder::EMAIL_ENDING)->pluck('id')->toArray();

        for ($i = 0; $i < self::REVIEWS_NUM; $i++) {
            $user_id = $user_ids[array_rand($user_ids)];
            $sku_id = self::getNotReviewedSkuId($user_id);

            $review_id = self::createReview($sku_id, $user_id);
            self::createReactions($review_id, $user_id, $user_ids);

            $this->reviewService->updateSkuRating($sku_id);
        }
    }


    private static function getNotReviewedSkuId(int $user_id): ?int
    {
        return Sku::select('id')
            ->whereDoesntHave('reviews', function (Builder $query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->orderByRaw('RANDOM() LIMIT 1')
            ->get()
            ->first()?->id;
    }


    private static function createReview(int $sku_id, int $user_id): int
    {
        $review = new Review();
        $review->sku_id = $sku_id;
        $review->user_id = $user_id;
        $review->term = fake()->randomElement(['days', 'weeks', 'months']);
        $review->mark = fake()->numberBetween(1, 5);
        $review->pros = fake()->realText(rand(100, 500));
        $review->cons = fake()->realText(rand(100, 500));
        $review->comnt = fake()->realText(rand(100, 500));
        $date_time = fake()->dateTimeBetween('-3 month');
        $review->created_at = $date_time;
        $review->updated_at = $date_time;
        $review->save();

        return $review->id;
    }


    private static function createReactions(int $review_id, int $user_id, array $user_ids): void
    {
        $num = rand(1, self::REACTIONS_MAX_NUM);
        $reviewed_user_ids = [];

        for ($i = 0; $i < $num; $i++) {
            do { $reviewed_user_id = $user_ids[array_rand($user_ids)]; }
            while ($reviewed_user_id === $user_id || in_array($reviewed_user_id, $reviewed_user_ids));

            $reviewed_user_ids[] = $reviewed_user_id;

            $reaction = new Reaction();
            $reaction->review_id = $review_id;
            $reaction->user_id = $reviewed_user_id;
            $reaction->up_down = (bool) rand(0, 1);
            $reaction->save();
        }
    }
}
