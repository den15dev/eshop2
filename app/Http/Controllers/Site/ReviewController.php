<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Categories\CategoryService;
use App\Modules\Products\ProductService;
use App\Modules\Products\RecentlyViewedService;
use App\Modules\Reviews\DTO\ReviewData;
use App\Modules\Reviews\Enums\TermOfUse;
use App\Modules\Reviews\Models\Review;
use App\Modules\Reviews\Services\Site\Requests\ReviewRequest;
use App\Modules\Reviews\Services\Site\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        private readonly ReviewService $reviewService
    )
    {}


    public function index(
        Request $request,
        CategoryService $categoryService,
        ProductService $productService,
        RecentlyViewedService $recentlyViewedService,
        string $category_slug,
        string $product_slug_id
    ): View {
        $category = $categoryService->getCategoryBySlug($category_slug);
        abort_if(!$category, 404);

        $slug_id = $productService::parseSlug($product_slug_id);
        $sku_id = $slug_id[1];

        $sku = $productService->getForReviews($sku_id);
        abort_if($sku->slug !== $slug_id[0], 404);

        $marks = $this->reviewService->countMarks($sku_id);

        $query = $this->reviewService->buildReviewsQuery($sku_id, Auth::id());
        $reviews = $query->paginate(6);
        $reviews_num = $reviews->total();

        $is_reviewed = $this->reviewService->isReviewed($sku_id, Auth::id());

        $rv_cookie = $request->cookie(RecentlyViewedService::COOKIE);
        $recently_viewed = $recentlyViewedService->get($rv_cookie);

        return view('site.pages.reviews', compact(
            'sku',
            'reviews',
            'reviews_num',
            'marks',
            'is_reviewed',
            'recently_viewed',
        ));
    }


    public function store(ReviewRequest $request)
    {
        $user = Auth::user();

        if ($user) {
            $review_data = $request->validated();
            $review_data['user_id'] = $user->id;

            $review = $this->reviewService->createReview($review_data);

            Log::channel('events')->info('__new_review_added__ ' . $review->sku_id);

            $message = __('reviews.review_added');
        } else {
            $request->flash();
            $message = __('reviews.session_expired');
        }

        $request->flashSuccessMessage($message);

        return back();
    }
}
