<div class="product-card">
    <a href="#" class="product-card_image">
        <img src="{{ asset('storage/images/products/1/01_230.jpg') }}" alt="Процессор">
        <div class="tint"></div>
    </a>
    <a href="#" class="product-card_name mb-1">
        {{ $num }}. Материнская плата MSI MPG B760I EDGE WIFI DDR4
    </a>
    <div class="product-card_description mb-2">
        LGA 1700, 8P x 2.1 ГГц, 8E x 1.5 ГГц, L2 - 24 МБ, L3 - 30 МБ, 2хDDR4, DDR5-5600 МГц, TDP 219 Вт
    </div>
    <a href="#" class="product-card_rating mb-1 small" title="3.88">
        <ul>
            <li class="icon-star-fill"></li>
            <li class="icon-star-fill"></li>
            <li class="icon-star-fill"></li>
            <li class="icon-star-half"></li>
            <li class="icon-star"></li>
        </ul>
        <div>(208)</div>
    </a>
    <div class="product-card_price mb-2">60 490 ₽</div>
    <button class="btn-2sizes">{{ __('catalog.product_card.add_to_cart') }}</button>
    <div class="product-card_buttons small">
        <div data-btn="compare">
            <span class="icon-bar-chart me-1"></span>
            {{ __('catalog.product_card.compare') }}
        </div>
        <div data-btn="favorite">
            <span class="icon-heart me-1"></span>
            {{ __('catalog.product_card.add_to_fav') }}
        </div>
    </div>
</div>