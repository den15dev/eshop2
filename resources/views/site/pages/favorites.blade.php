@extends('site.layout')

@section('page_title', __('favorites.favorites') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h3 class="mb-4">{{ __('favorites.favorites') }}</h3>

        <div class="catalog-cont mb-6">
            @if($products->count())
                <div class="catalog-cards-cont mb-5">
                    @foreach($products as $product)
                        <x-product-card :product="$product"/>
                    @endforeach
                </div>

                @include('site.includes.pagination')
            @else
                <div class="items-not-found">
                    {{ __('catalog.no_products') }}
                </div>
            @endif
        </div>

        @if($recently_viewed->count())
            @include('site.includes.recently-viewed')
        @endif
    </div>
@endsection