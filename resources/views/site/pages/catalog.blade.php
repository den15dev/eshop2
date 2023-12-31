@extends('site.layout')

@section('page_title', 'Процессоры' . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <x-breadcrumb :breadcrumb="$breadcrumb" />

        <div class="catalog-page-wrap mb-6">
            <div class="sidebar-cont">
                <form method="GET" action="" id="filterFormDesktop">
                    <x-catalog-filters-dropdown type="price"
                                                title="Цена"
                                                :data="$price_range"
                                                collapsed="off"
                                                :ismobile="false" />

                    <x-catalog-filters-dropdown type="brands"
                                                title="Бренды"
                                                :data="$brands"
                                                collapsed="off"
                                                :ismobile="false" />

                    @foreach($filter_specs as $spec)
                        <x-catalog-filters-dropdown type="specs"
                                                    title="{{ $spec->name }}"
                                                    :data="$spec"
                                                    collapsed="{{ $loop->index > 0 ? 'on' : 'off' }}"
                                                    :ismobile="false" />
                    @endforeach

                    <div class="catalog-filters_btn-cont">
                        <button type="submit">{{ __('catalog.filters.apply') }}</button>
                        <a href="#" class="btn btn-bg-grey">{{ __('catalog.filters.reset') }}</a>
                    </div>
                </form>
            </div>

            <div class="catalog-cont">
                @include('site.pages.catalog-settings')

                @if($products->count())
                    <div class="catalog-cards-cont mb-5">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>


                    @include('site.includes.pagination')
                @else
                    <div class="items-not-found">
                        Нет товаров
                    </div>
                @endif
            </div>
        </div>


        @if($recently_viewed->count())
            @include('site.includes.recently-viewed')
        @endif
    </div>
@endsection