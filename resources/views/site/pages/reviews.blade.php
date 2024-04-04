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

        <div class="reviews-page-cont">
            <div class="reviews-main-cont">
                @php
                    $marks_max = $marks ? max($marks) : 0;
                @endphp

                <a href="{{ $sku->url }}" class="btn-link link mb-25">
                    <span class="icon-chevron-left small va1"></span>
                    {{ __('reviews.back_to_product') }}
                </a>

                <div class="reviews-head-cont">
                    <a href="{{ $sku->url }}">
                        <img src="{{ $sku->image_md }}" alt="{{ $sku->name }}">
                    </a>
                    <div class="reviews-head-name-cont">
                        <h5>
                            <a class="reviews-head-name mb-1" href="{{ $sku->url }}">
                            {{ $sku->name }}
                            </a>
                            @if($sku->promo_id)
                            &nbsp;<a href="{{ route('promo', $sku->promo_url_slug) }}" class="product-name_badge-link-small" title="{{ $sku->promo_name }}">-{{ $sku->discount_prc }}%</a>
                            @elseif($sku->discount_prc)
                            &nbsp;<div class="product-name_badge-small">-{{ $sku->discount_prc }}%</div>
                            @endif
                        </h5>
                        @if($reviews_num)
                            {{ trans_choice('reviews.reviews_num', $reviews_num) }}
                        @else
                            <span class="lightgrey-text">{{ __('reviews.no_reviews') }}</span>
                        @endif
                    </div>
                </div>

                <x-reviews-rating type="mobile"
                                  :rating="$sku->rating"
                                  :ratingformatted="$sku->rating_formatted"
                                  :num="$sku->vote_num"
                                  :marks="$marks"
                                  :max="$marks_max" />

                @foreach($reviews as $review)
                    <x-review :review="$review" :reactionsoff="$is_guest || $review->is_author" />
                @endforeach
            </div>


            <div class="reviews-side-cont">
                <x-reviews-rating :rating="$sku->rating"
                                  :ratingformatted="$sku->rating_formatted"
                                  :num="$sku->vote_num"
                                  :marks="$marks"
                                  :max="$marks_max" />
            </div>
        </div>

        @if($reviews->hasPages())
            <div class="mb-6">
                {{ $reviews->links('common.pagination.results-shown') }}
                {{ $reviews->onEachSide(1)->withQueryString()->links('common.pagination.page-links') }}
            </div>
        @endif

        @auth()
            @if($is_reviewed)
                <div class="lightgrey-text py-3 mb-6">{{ __('reviews.already_reviewed') }}</div>
            @else
                @include('site.pages.review-form')
            @endif
        @else
            <div class="lightgrey-text py-3 mb-6">{{ __('reviews.sign_in_to_review') }}</div>
        @endauth

        @if($recently_viewed->count())
            @include('site.includes.recently-viewed')
        @endif
    </div>
@endsection