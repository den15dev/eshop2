<?php

namespace Database\Seeders;

use App\Modules\Reviews\Models\Review;
use App\Modules\Reviews\ReviewService;
use App\Modules\Users\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewAndUserUnseeder extends Seeder
{
    public function __construct(
        private readonly ReviewService $reviewService,
    ){}


    /**
     * Unseed fake users and reviews, and update SKUs' rating back.
     */
    public function run(): void
    {
        $user_ids = User::where('email', 'like', '%' . UserSeeder::EMAIL_ENDING)->pluck('id')->toArray();

        $sku_ids = DB::table('reviews')
            ->select('sku_id')
            ->whereIn('user_id', $user_ids)
            ->groupBy('sku_id')
            ->get()
            ->pluck('sku_id')
            ->toArray();

        Review::whereIn('user_id', $user_ids)->delete();
        User::where('email', 'like', '%' . UserSeeder::EMAIL_ENDING)->delete();

        foreach ($sku_ids as $sku_id) {
            $this->reviewService->updateSkuRating($sku_id);
        }
    }
}
