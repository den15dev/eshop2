@extends('site.layout')

@section('main_content')
    <div class="container">
        <div class="promo-banner mb-4">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="#">
                            <picture>
                                <source srcset="{{ asset('storage/images/promos/1/akcia_na_videokarty_nvidia.jpg') }}" media="(min-width: 1140px)" />
                                <source srcset="{{ asset('storage/images/promos/1/akcia_na_videokarty_nvidia_1140.jpg') }}" media="(min-width: 992px)" />
                                <source srcset="{{ asset('storage/images/promos/1/akcia_na_videokarty_nvidia_992.jpg') }}" media="(min-width: 768px)" />
                                <img src="{{ asset('storage/images/promos/1/akcia_na_videokarty_nvidia_788.jpg') }}" alt="" />
                            </picture>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#">
                            <picture>
                                <source srcset="{{ asset('storage/images/promos/2/amd_cpu_promo_001.jpg') }}" media="(min-width: 1140px)" />
                                <source srcset="{{ asset('storage/images/promos/2/amd_cpu_promo_001_1140.jpg') }}" media="(min-width: 992px)" />
                                <source srcset="{{ asset('storage/images/promos/2/amd_cpu_promo_001_992.jpg') }}" media="(min-width: 768px)" />
                                <img src="{{ asset('storage/images/promos/2/amd_cpu_promo_001_788.jpg') }}" alt="" />
                            </picture>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#">
                            <picture>
                                <source srcset="{{ asset('storage/images/promos/3/intel_13gen_promo_001.jpg') }}" media="(min-width: 1140px)" />
                                <source srcset="{{ asset('storage/images/promos/3/intel_13gen_promo_001_1140.jpg') }}" media="(min-width: 992px)" />
                                <source srcset="{{ asset('storage/images/promos/3/intel_13gen_promo_001_992.jpg') }}" media="(min-width: 768px)" />
                                <img src="{{ asset('storage/images/promos/3/intel_13gen_promo_001_788.jpg') }}" alt="" />
                            </picture>
                        </a>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="swiper-pagination-outside"></div>
        </div>


        <h3>{{ __('home.best_prices') }}</h3>

        <div class="swiper product-carousel mb-6">
            <div class="swiper-wrapper">
                @foreach($products as $product)
                    <div class="swiper-slide">
                        <x-product-card :product="$product" />
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
                @foreach($products as $product)
                    <div class="swiper-slide">
                        <x-product-card :product="$product" />
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
                @foreach($popular_products as $product)
                    <div class="swiper-slide">
                        <x-product-card :product="$product" />
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