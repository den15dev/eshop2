@extends('site.layout')

@section('page_title', __('search.search_results') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h4 class="mb-4">{{ __('search.query_results', ['query' => $search_query, 'num' => 19]) }}</h4>

        <div class="catalog-page-wrap mb-6">
            <div class="sidebar-cont">
                <form method="GET" action="" id="filterFormDesktop">
                    @include('site.pages.' . $filters . '-filters', ['ismobile' => false])

                    <div class="filters_btn-cont">
                        <button type="submit">{{ __('catalog.filters.apply') }}</button>
                        <a href="#" class="btn btn-bg-grey">{{ __('catalog.filters.reset') }}</a>
                    </div>
                </form>
            </div>

            <div class="catalog-cont">
                @include('site.pages.catalog-prefs')

                @if($products->count())
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

                    @include('site.includes.pagination')
                @else
                    <div class="items-not-found">
                        {{ __('catalog.no_products') }}
                    </div>
                @endif
            </div>
        </div>


        @if($recently_viewed->count())
            @include('site.includes.recently-viewed')
        @endif
    </div>
@endsection