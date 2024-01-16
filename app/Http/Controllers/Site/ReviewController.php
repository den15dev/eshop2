<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Products\ProductService;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $product = new \stdClass();
        $product->id = 38;
        $product->name = 'Материнская плата ASUS TUF GAMING B660M-PLUS WIFI D4';
        $product->slug = 'processor-amd-ryzen-5-5600x-box';
        $product->category_slug = 'cpu';

        $product->rating = 4.47;
        $product->vote_num = 208;

        $marks = [2, 0, 3, 15, 4];

        $reviews = new Collection([]);
        $reviews_num = 5;
        for($i = 1; $i <= $reviews_num; $i++) {
            $review = new \stdClass();
            $review->id = $i;
            $review->term = __('reviews.term.days');
            $review->mark = fake()->numberBetween(1, 5);
            $review->pros = fake('ru_RU')->realText(400);
            $review->cons = fake('ru_RU')->realText(400);
            $review->comnt = fake('ru_RU')->realText(400);
            $review->created_at = fake()->dateTimeBetween('-3 month');

            $user = new \stdClass();
            $user->name = 'Константин';
            $review->user = $user;

            $reviews->push($review);
        }


        $recently_viewed = ProductService::getSomeProducts(8);


        return view('site.pages.reviews', compact(
            'product',
            'reviews',
            'marks',
            'recently_viewed',
        ));
    }


    public function store()
    {
        session()->flash('message', [
            'type' => 'success',
            'content' => __('reviews.review_added'),
            'align' => 'center',
        ]);

        return back();
    }
}
