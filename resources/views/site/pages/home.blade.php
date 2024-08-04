@extends('site.layout')

@section('main_content')
    <div class="container">
        <div class="promo-banner mb-4">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach($promos as $promo)
                        <div class="swiper-slide">
                            <a href="{{ $promo->url }}">
                                <picture>
                                    <source srcset="{{ $promo->getImageURL('xxl') }}" media="(min-width: {{ $promo::IMG_SIZES['xl'] }}px)" />
                                    <source srcset="{{ $promo->getImageURL('xl') }}" media="(min-width: {{ $promo::IMG_SIZES['lg'] }}px)" />
                                    <source srcset="{{ $promo->getImageURL('lg') }}" media="(min-width: {{ $promo::IMG_SIZES['md'] }}px)" />
                                    <img src="{{ $promo->getImageURL('md') }}" alt="{{ $promo->name }}" />
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

        @if($skus_discounted->count())
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
        @endif


        <h3>{{ __('home.new') }}</h3>

        @if($skus_latest->count())
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
        @endif


        <h3>{{ __('home.popular') }}</h3>

        @if($skus_latest->count())
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
        @endif
    </div>
@endsection
