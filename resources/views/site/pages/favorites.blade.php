@extends('site.layout')

@section('page_title', __('favorites.favorites') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h3 class="mb-4">{{ __('favorites.favorites') }}</h3>

        <div class="mb-65">
            @if($skus->count())
                <div class="catalog-cards-cont mb-5">
                    @foreach($skus as $sku)
                        <x-product-card :sku="$sku"/>
                    @endforeach
                </div>

                {{ $skus->hasPages() ? $skus->links('common.pagination.results-shown') : '' }}
                {{ $skus->onEachSide(1)->withQueryString()->links('common.pagination.page-links') }}
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