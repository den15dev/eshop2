@extends('site.layout')

@section('page_title', 'Процессор AMD Ryzen 5 5600X BOX' . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <x-breadcrumb :breadcrumb="$breadcrumb" />

        <h4 class="mb-3">
            {{ $product->name }}
            @if($product->promo_id)
            &nbsp;<a href="{{ route('promo', $product->promo_url_slug) }}" class="product-name_badge" title="{{ $product->promo_name }}">-{{ $product->discount_prc }}%</a>
            @endif
        </h4>

        <div class="product-code mb-3">
            <div>{{ __('product.product_id') }}: {{ $product->id }}</div>

            <x-rating size="small"
                      :url="route('reviews', [$product->category_slug, $product->slug . '-' . $product->id])"
                      :rating="$product->rating"
                      :num="$product->vote_num"/>
        </div>

        <div class="product-main-cont mb-5">
            <div class="product-main_image mb-3">
                <div class="f-carousel" id="productImages">
                    @if($product->images)
                        @foreach($product->images as $image)
                            <div class="f-carousel__slide"
                                 data-thumb-src="{{ get_image('storage/images/products/' . (($product->id - 1) % 4 + 1) . '/' . $image . '_80.jpg', 80) }}"
                                 data-fancybox="product_images"
                                 data-src="{{ get_image('storage/images/products/' . (($product->id - 1) % 4 + 1) . '/' . $image . '_big.jpg', 1400) }}">
                                <img src="{{ get_image('storage/images/products/' . (($product->id - 1) % 4 + 1) . '/' . $image . '_600.jpg', 600) }}" alt="">
                            </div>
                        @endforeach
                    @else
                        <img src="{{ asset('img/default/no-image_600.jpg') }}" alt="">
                    @endif
                </div>
            </div>


            <div class="product-main_specs">
                <div class="mb-3">
                    <div><b>{{ __('product.sku_code') }}:</b></div>
                    100-100000065BOX
                </div>

                <div class="mb-5">
                    <div class="mb-1"><b>{{ __('product.specs') }}:</b></div>
                    <ul class="product-main_spec-list">
                        <li><span>Серия:</span> AMD Ryzen 5</li>
                        <li><span>Модель:</span> 5600X</li>
                        <li><span>Сокет:</span> AM4</li>
                        <li><span>Год релиза:</span> 2020</li>
                        <li><span>Ядро:</span> AMD Vermeer</li>
                        <li><span>Техпроцесс:</span> TSMC 7FF</li>
                        <li><span>Общее количество ядер:</span> 6</li>
                        <li><a href="#" class="link">{{ __('product.all_specs') }}</a></li>
                    </ul>
                </div>

                <a href="{{ $product->brand->url }}" class="product-main_brand">
                    <img src="{{ $product->brand->image_url }}" alt="{{ $product->brand->name }}">
                </a>
            </div>


            <div class="product-main_price">

                <div class="mb-35">
                    <div class="variant-cont dropdown mb-3">
                        <div class="dropdown-label small">Color:</div>
                        <div class="dropdown-btn" data-variant-id="1">
                            Black
                            <span class="icon-chevron-down xsmall"></span>
                        </div>
                        <ul class="dropdown-list">
                            <li>
                                <div class="dropdown-item active" data-variant-id="2">
                                    Black <span class="icon-check-lg"></span>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-item" data-variant-id="3">
                                    White
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-item disabled" data-variant-id="4">
                                    Silver
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-item" data-variant-id="4">
                                    Purple
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="variant-cont dropdown mb-3">
                        <div class="dropdown-label small">Memory capacity:</div>
                        <div class="dropdown-btn" data-variant-id="1">
                            64Gb
                            <span class="icon-chevron-down xsmall"></span>
                        </div>
                        <ul class="dropdown-list">
                            <li>
                                <div class="dropdown-item active" data-variant-id="2">
                                    64Gb <span class="icon-check-lg"></span>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-item" data-variant-id="3">
                                    128Gb
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-item disabled" data-variant-id="3">
                                    256Gb
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-item" data-variant-id="3">
                                    512Gb
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>



                <div class="mb-3">
                    @if($product->discount_prc)
                        <div class="product-main_old-price">
                            <del>{!! $product->price_formatted !!}</del>
                        </div>
                    @endif
                    <div class="product-main_cur-price">{!! $product->final_price_formatted !!}</div>
                </div>

                <div class="product-main_add-btn-cont mb-4">
                    <div class="quantity-btns">
                        <button class="btn-qty-minus">
                            <svg viewBox="0 0 10 2"><use href="#minusIcon"/></svg>
                        </button>
                        <input name="qty" type="text" value="1">
                        <button class="btn-qty-plus">
                            <svg viewBox="0 0 12 12"><use href="#plusIcon"/></svg>
                        </button>
                    </div>

                    <button>{{ __('catalog.product_card.add_to_cart') }}</button>
                </div>

                <div class="product-btn-cont mb-3">
                    <x-product-btn-compare :id="$product->id" :catid="$product->category_id" :active="$product->is_comparing" />
                    <x-product-btn-favorites :id="$product->id" :active="$product->is_favorite" />
                </div>
            </div>
        </div>


        <div class="mb-6">
            <nav class="tab-cont mb-4">
                <div class="tab-btn active" role="button" id="descriptionTab">
                    {{ __('product.description') }}
                </div>
                <div class="tab-btn link" role="button" id="specTab">
                    {{ __('product.specs') }}
                </div>
                <a href="{{ route('reviews', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="tab-btn link">
                    {{ __('product.reviews') }}
                </a>
            </nav>


            <div class="tab-pane active" id="descriptionTabPane">
                <p>
                    Процессор AMD Ryzen 5 5600X BOX сделает игровой ПК более производительным. Построенная на 7-нм техпроцессе архитектура Zen 3 обеспечивает высокую скорость обмена данными между 6 ядрами и кэш-памятью L3 на 32 МБ. Это позволит выполнять все действия быстро и точно. При увеличении нагрузки автоматически повышается тактовая частота процессора: с 3.7 до 4.6 ГГц. В случае необходимости можно задать еще большую частоту благодаря свободному множителю. Тепловыделение составляет 65 Вт.
                </p>
                <p>
                    Для поддержания стабильной работы процессора AMD Ryzen 5 5600X BOX и предупреждения его перегрева, в комплекте с ним предусмотрена система охлаждения и нанесенный на основание радиатора термоинтерфейс. В конструкции процессора имеется 2 линии для подключения модулей ОЗУ DDR4-3200 общим объемом 128 ГБ. Поддерживаемая технология виртуализации увеличивает вычислительные мощности процессора и оптимизирует его возможности. Благодаря этому возможна работа в нескольких операционных системах и загрузка игр в эмуляторах.
                </p>
            </div>


            <div class="tab-pane" id="specTabPane">
                <table class="table spec_table mb-4">
                    <tbody>
                    @foreach($product->specifications->sortBy('sort') as $spec)
                        <tr>
                            <td>{{ $spec->name }}</td>
                            @php
                                $spec_value = $spec->pivot->spec_value;
                                $units = $spec->units ? ' ' . $spec->units : '';
                                if (in_array($spec_value, ['нет', 'да', 'есть', '-'])) $units = '';
                            @endphp
                            @if($loop->first)
                                <td class="item_spec_col2">{{ $spec_value . $units }}</td>
                            @else
                                <td>{{ $spec_value . $units }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="product-btn-cont mb-4">
                    <x-product-btn-compare :id="$product->id" :catid="$product->category_id" :active="$product->is_comparing" />
                </div>
            </div>
        </div>

        @if($recently_viewed->count())
            @include('site.includes.recently-viewed')
        @endif
    </div>
@endsection