<h3 class="mb-4">{{ __('catalog.recent') }}</h3>

<div class="swiper product-carousel mb-2">
    <div class="swiper-wrapper">
        @foreach($recently_viewed as $sku)
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