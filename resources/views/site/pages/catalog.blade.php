@extends('site.layout')

@section('page_title', $category->name . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <x-breadcrumb :breadcrumb="$breadcrumb"/>

        @if($products->count())
            <div class="catalog-page-wrap mb-6">
                <div class="sidebar-cont">
                    <form method="GET" action="" id="filterFormDesktop">
                        @include('site.pages.' . $filters . '-filters', ['ismobile' => false])

                        <div class="filters_btn-cont">
                            <button type="submit">{{ __('catalog.filters.apply') }}</button>
                            <a href="{{ $filter_reset_url }}" class="btn btn-bg-grey">{{ __('catalog.filters.reset') }}</a>
                        </div>
                    </form>
                </div>

                <div class="catalog-cont">
                    @include('site.pages.catalog-prefs')

                    @if($prefs->layout === 1)
                        <div class="catalog-cards-cont mb-5">
                            @foreach($products as $product)
                                <x-product-card :product="$product"/>
                            @endforeach
                        </div>

                    @elseif($prefs->layout === 2)
                        @foreach($products as $product)
                            <x-product-row :product="$product"/>
                        @endforeach
                    @endif

                    {{ $products->links('common.pagination.results-shown') }}
                    {{ $products->onEachSide(1)->withQueryString()->links('common.pagination.page-links') }}
                </div>
            </div>
        @else
            <div class="items-not-found">
                {{ __('catalog.no_products') }}
            </div>
        @endif


        @if($recently_viewed->count())
            @include('site.includes.recently-viewed')
        @endif
    </div>
@endsection