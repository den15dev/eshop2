@extends('site.layout')

@section('page_title', __('cart.cart') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        @if(count($skus))
            <div class="cart-cont mb-5">
                <div class="cart-head-cont">
                    <h3 class="mb-0">{{ __('cart.cart') }}</h3>
                    <div class="btn-link link" role="button" id="clearCartBtn">{{ __('cart.clear_cart') }}</div>
                </div>

                <div class="cart-items-cont mb-25">
                    @foreach($skus as $sku)
                        <x-cart-item :num="$loop->index + 1" :sku="$sku" />
                    @endforeach
                </div>

                <div class="cart-total-cont">
                    <div class="cart-total_text">{{ __('cart.total') }}:</div>
                    <div class="cart-total_sum">
                        @if($total->cost)
                            <div class="product-card_old-price">
                                <del>{!! $total->cost_formatted !!}</del>
                            </div>
                        @endif
                        <div class="product-card_price">{!! $total->final_cost_formatted !!}</div>
                    </div>
                </div>
            </div>

            @include('site.pages.cart-form')
        @else
            <div class="items-not-found">
                {{ __('cart.empty') }}
            </div>

            @if($recently_viewed->count())
                @include('site.includes.recently-viewed')
            @endif
        @endif
    </div>
@endsection