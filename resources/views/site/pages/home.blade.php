@extends('site.layout')

@section('main_content')
    <div class="container">
        <div class="promo-banner mb-4">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach($promos as $promo)
                        <div class="swiper-slide">
                            <a href="{{ route('promo', $promo->slug . '-' . $promo->id) }}">
                                <picture>
                                    <source srcset="{{ $promo->images->size_1296 }}" media="(min-width: 1140px)" />
                                    <source srcset="{{ $promo->images->size_1140 }}" media="(min-width: 992px)" />
                                    <source srcset="{{ $promo->images->size_992 }}" media="(min-width: 768px)" />
                                    <img src="{{ $promo->images->size_788 }}" alt="" />
                                </picture>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="swiper-pagination-outside"></div>
        </div>


        <h3>{{ __('home.best_prices') }}</h3>

        <div class="swiper product-carousel mb-6">
            <div class="swiper-wrapper">
                @foreach($skus_discounted as $sku)
                    <div class="swiper-slide">
                        <x-product-card :sku="$sku" />
                    </div>
                @endforeach
            </div>
            <div class="carousel-next-btn">
                <span class="icon-chevron-right"></span>
            </div>
            <div class="carousel-prev-btn">
                <span class="icon-chevron-left"></span>
            </div>
        </div>


        <h3>{{ __('home.new') }}</h3>

        <div class="swiper product-carousel mb-6">
            <div class="swiper-wrapper">
                @foreach($skus_latest as $sku)
                    <div class="swiper-slide">
                        <x-product-card :sku="$sku" />
                    </div>
                @endforeach
            </div>
            <div class="carousel-next-btn">
                <span class="icon-chevron-right"></span>
            </div>
            <div class="carousel-prev-btn">
                <span class="icon-chevron-left"></span>
            </div>
        </div>


        <h3>{{ __('home.popular') }}</h3>

        <div class="swiper product-carousel mb-5">
            <div class="swiper-wrapper">
                @foreach($skus_popular as $sku)
                    <div class="swiper-slide">
                        <x-product-card :sku="$sku" />
                    </div>
                @endforeach
            </div>
            <div class="carousel-next-btn">
                <span class="icon-chevron-right"></span>
            </div>
            <div class="carousel-prev-btn">
                <span class="icon-chevron-left"></span>
            </div>
        </div>
    </div>
@endsection