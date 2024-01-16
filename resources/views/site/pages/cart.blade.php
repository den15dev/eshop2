@extends('site.layout')

@section('page_title', __('cart.cart') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <div class="cart-cont mb-4">
            <div class="cart-head-cont">
                <h3 class="mb-0">{{ __('cart.cart') }}</h3>
                <div class="btn-link link" role="button">{{ __('cart.clear_cart') }}</div>
            </div>

            <div class="cart-items-cont mb-25">
                @foreach($products as $product)
                    <x-cart-item :num="$loop->index + 1" :product="$product" />
                @endforeach
            </div>

            <div class="cart-total-cont">
                <div class="cart-total_text">{{ __('cart.total') }}:</div>
                <div class="cart-total_sum">
                    @if($total->sum)
                        <div class="product-card_old-price">
                            <del>{{ $total->sum }} ₽</del>
                        </div>
                    @endif
                    <div class="product-card_price">{{ $total->final_sum }} ₽</div>
                </div>
            </div>
        </div>

        @include('site.pages.cart-form')
    </div>
@endsection