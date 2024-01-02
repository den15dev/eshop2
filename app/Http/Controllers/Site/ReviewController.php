<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
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


        $discounts = [0, 0, 5, 10, 0, 0, 0, 5, 0, 5, 0, 10, 0, 0];
        $recently_viewed = new Collection([]);
        for ($i = 1; $i <= 8; $i++) {
            $temp_product = new \stdClass();
            $temp_product->id = $i;
            $temp_product->name = 'Материнская плата MSI MPG B760I EDGE WIFI DDR4';
            $temp_product->slug = 'processor-amd-ryzen-5-5600x-box';
            $temp_product->category_slug = 'cpu';
            $temp_product->category_id = 6;
            $temp_product->short_descr = 'LGA 1700, 8P x 2.1 ГГц, 8E x 1.5 ГГц, L2 - 24 МБ, L3 - 30 МБ, 2хDDR4, DDR5-5600 МГц, TDP 219 Вт';

            $temp_product->discount_prc = $discounts[$i];
            $temp_product->price = 60490;
            if ($temp_product->discount_prc) {
                $temp_product->final_price = number_format($temp_product->price * (100 - $temp_product->discount_prc)/100, 0, ',', ' ');
            } else {
                $temp_product->final_price = $temp_product->price;
            }
            $temp_product->price = number_format($temp_product->price, 0, ',', ' ');

            $temp_product->rating = 3.85;
            $temp_product->vote_num = 208;

            $recently_viewed->push($temp_product);
        }


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
