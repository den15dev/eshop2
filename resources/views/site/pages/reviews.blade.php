@extends('site.layout')

@section('page_title', 'Процессор AMD Ryzen 5 5600X BOX' . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <svg width="2" height="2" style="display: none">
            <symbol viewBox="0 0 38 38" id="userGreyAvatar">
                <path d="M38 0H0V38H38V0Z" fill="#f0f0f0"/>
                <path d="M19 21.432C23.4492 21.432 27.056 17.8252 27.056 13.376C27.056 8.9268 23.4492 5.32001 19 5.32001C14.5508 5.32001 10.944 8.9268 10.944 13.376C10.944 17.8252 14.5508 21.432 19 21.432Z" fill="#d2d2d2"/>
                <path d="M34.8967 38C34.8967 32.1923 33.1233 23.7943 24.9913 21.736C21.5017 24.3833 16.1817 24.225 13.015 21.736C4.87667 23.7943 3.10333 32.1923 3.10333 38C6.65 38 31.35 38 34.8967 38Z" fill="#d2d2d2"/>
            </symbol>
        </svg>

        <div class="reviews-page-cont mb-5">
            <div class="reviews-main-cont">
                @php
                    $product_url = route('product', [$product->category_slug, $product->slug . '-' . $product->id]);
                    $marks_max = $marks ? max($marks) : 0;
                @endphp

                <a href="{{ $product_url }}" class="btn-link link mb-25">
                    <span class="icon-chevron-left small va1"></span>
                    {{ __('reviews.back_to_product') }}
                </a>

                <div class="reviews-head-cont">
                    <a href="{{ $product_url }}">
                        <img src="{{ asset('storage/images/products/4/01_230.jpg') }}" alt="{{ $product->name }}">
                    </a>
                    <div class="reviews-head-name-cont">
                        <h5>
                            <a class="reviews-head-name mb-1" href="{{ $product_url }}">
                            {{ $product->name }}
                            </a>
                            @if($product->promo_id)
                            &nbsp;<a href="{{ route('promo', $product->promo_url_slug) }}" class="product-name_badge-small" title="{{ $product->promo_name }}">-{{ $product->discount_prc }}%</a>
                            @endif
                        </h5>
                        {{ trans_choice('reviews.reviews_num', $reviews->count()) }}
                    </div>
                </div>

                <x-reviews-rating type="mobile"
                                  :rating="$product->rating"
                                  :num="$product->vote_num"
                                  :marks="$marks"
                                  :max="$marks_max" />

                @foreach($reviews as $review)
                    <x-review />
                @endforeach

                @include('site.includes.pagination')
            </div>


            <div class="reviews-side-cont">
                <x-reviews-rating :rating="$product->rating"
                                  :num="$product->vote_num"
                                  :marks="$marks"
                                  :max="$marks_max" />
            </div>
        </div>


        @include('site.pages.review-form')
{{--        <div class="lightgrey-text large mb-6">{{ __('reviews.sign_in_to_review') }}</div>--}}

        @if($recently_viewed->count())
            @include('site.includes.recently-viewed')
        @endif
    </div>
@endsection