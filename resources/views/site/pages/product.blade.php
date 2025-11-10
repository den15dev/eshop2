@extends('site.layout')

@section('page_title', $sku->name . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <x-breadcrumb :breadcrumb="$breadcrumb"/>

        <h4 class="mb-3">
            {{ $sku->name }}
            @if($sku->promo_id)
                &nbsp;<a href="{{ route('promo', $sku->promo_url_slug) }}" class="product-name_badge-link"
                         title="{{ $sku->promo_name }}">-{{ $sku->discount }}%</a>
            @elseif($sku->discount)
                &nbsp;
                <div class="product-name_badge" title="{{ $sku->promo_name }}">-{{ $sku->discount }}%</div>
            @endif
        </h4>

        <div class="product-code mb-3">
            <div>{{ __('product.sku_code') }}: {{ $sku->code }}</div>

            <x-rating size="small"
                      :url="route('reviews', [$sku->category_slug, $sku->url_slug])"
                      :rating="$sku->rating"
                      :ratingformatted="$sku->rating_formatted"
                      :num="$sku->vote_num"/>
        </div>

        <div class="product-main-cont mb-5">
            <div class="product-main_image mb-3">
                <div class="f-carousel" id="productImages">
                    @if($sku->images)
                        @foreach($sku->images as $image)
                            <div class="f-carousel__slide"
                                 data-thumb-src="{{ $sku->getImageURL('tn', $image) }}"
                                 data-fancybox="product_images"
                                 data-src="{{ $sku->getImageURL('lg', $image) }}">
                                <img src="{{ $sku->getImageURL('md', $image) }}" alt="{{ $sku->name }}">
                            </div>
                        @endforeach
                    @else
                        <img src="{{ asset('img/default/no-image_md.jpg') }}" alt="">
                    @endif
                </div>
            </div>


            <div class="product-main_specs">
                <div class="mb-35">
                    <div class="product-main_spec-title"><b>{{ __('product.manufacturer_code') }}:</b></div>
                    {{ $sku->sku }}
                </div>

                <div class="mb-5">
                    <div class="product-main_spec-title"><b>{{ __('product.specs') }}:</b></div>

                    <ul class="product-main_spec-list">
                        @foreach($sku->specifications as $spec)
                            @if($spec->is_main)
                                <li><span>{{ $spec->name }}:</span> {{ $spec->value . $spec->units_str }}</li>
                            @endif

                            @if($loop->last)
                                <li>
                                    <div class="link">{{ __('product.all_specs') }}</div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>


                @isset($brand->image_url)
                    <a href="{{ route('brand', $brand->slug) }}" class="product-main_brand">
                        <img src="{{ $brand->image_url }}" alt="{{ $brand->name }}">
                    </a>
                @else
                    <a href="{{ route('brand', $brand->slug) }}" class="link">
                        {{ $brand->name }}
                    </a>
                @endisset
            </div>


            <div class="product-main_price">

                @if($attributes->count())
                    <div class="mb-35">
                        @foreach($attributes as $attribute)
                            <div class="attribute-cont dropdown mb-3">
                                <div class="dropdown-label small">{{ $attribute->name }}:</div>
                                <div class="dropdown-btn" data-variant-id="1">
                                    {{ $attribute->cur_variant->name }}
                                    <span class="icon-chevron-down xsmall"></span>
                                </div>
                                <ul class="dropdown-list">
                                    @foreach($attribute->variant_list as $variant)
                                        <li>
                                            @if($variant->is_current)
                                                <div class="dropdown-item active">
                                                    {{ $variant->name }} <span class="icon-check-lg"></span>
                                                </div>
                                            @elseif($variant->url)
                                                <a href="{{ $variant->url }}" class="dropdown-item" data-variant-id="3">
                                                    {{ $variant->name }}
                                                </a>
                                            @else
                                                <div class="dropdown-item disabled" data-variant-id="4">
                                                    {{ $variant->name }}
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif


                <div class="mb-3">
                    @if($sku->discount)
                        <div class="product-main_old-price">
                            <del>{!! $sku->price_formatted !!}</del>
                        </div>
                    @endif
                    <div class="product-main_cur-price">{!! $sku->final_price_formatted !!}</div>
                </div>

                <div class="product-main_add-btn-cont mb-4">
                    @if($sku->is_active)
                        <x-quantity-btns :skuid="$sku->id" :incart="$sku->in_cart ?: 1"/>

                        <a href="{{ route('cart') }}"
                           class="btn btn-bg-grey {{ $sku->in_cart ? '' : 'hidden' }}"
                           id="productGoToCartBtn"
                           title="{{ __('cart.buttons.go_to_cart') }}">{{ __('cart.buttons.in_cart') }}</a>

                        <button {!! $sku->in_cart ? 'class="hidden"' : '' !!} id="productAddToCartBtn"
                                data-id="{{ $sku->id }}"
                                data-incart="{{ $sku->in_cart }}">{{ __('cart.buttons.add_to_cart') }}</button>
                    @else
                        <div class="btn btn-outlined-inactive"
                             id="productOutOfStockBtn">{{ __('cart.buttons.out_of_stock') }}</div>
                    @endif
                </div>

                <div class="product-btn-cont mb-3">
                    <x-product-btn-compare :id="$sku->id" :catid="$sku->category_id" :active="$sku->is_comparing"/>
                    <x-product-btn-favorites :id="$sku->id" :active="$sku->is_favorite"/>
                </div>
            </div>
        </div>


        <div class="mb-6">
            <nav class="tab-cont mb-4" id="productPageTabs">
                <div class="tab-btn active" role="button" id="descriptionTab">
                    {{ __('product.description') }}
                </div>
                <div class="tab-btn link" role="button" id="specTab">
                    {{ __('product.specs') }}
                </div>
                <a href="{{ route('reviews', [$sku->category_slug, $sku->slug . '-' . $sku->id]) }}"
                   class="tab-btn link">
                    {{ __('product.reviews') }} ({{ $sku->reviews_count }})
                </a>
            </nav>


            <div class="tab-pane active" id="descriptionTabPane">
                {!! to_paragraphs($sku->description) !!}
            </div>


            <div class="tab-pane" id="specTabPane">
                <table class="table spec_table mb-4">
                    <tbody>
                    @foreach($sku->specifications->sortBy('sort') as $spec)
                        <tr>
                            <td>{{ $spec->name }}</td>
                            @if($loop->first)
                                <td class="item_spec_col2">{{ $spec->value . $spec->units_str }}</td>
                            @else
                                <td>{{ $spec->value . $spec->units_str }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="product-btn-cont mb-4">
                    <x-product-btn-compare :id="$sku->id" :catid="$sku->category_id" :active="$sku->is_comparing"/>
                </div>
            </div>
        </div>

        @if($recently_viewed->count())
            @include('site.includes.recently-viewed')
        @endif
    </div>
@endsection
