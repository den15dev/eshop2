@extends('site.layout')

@section('page_title', 'Процессоры' . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <nav class="breadcrumb-cont mb-3" aria-label="breadcrumb">
            <ol class="breadcrumb mt-0">
                <li class="breadcrumb-item"><a href="#" class="dark-link">Главная</a></li>
                <li class="breadcrumb-item"><a href="#" class="dark-link">Компьютерные комплектующие</a></li>
                <li class="breadcrumb-item active" aria-current="page">Процессоры</li>
            </ol>
        </nav>

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

                <div class="catalog-cards-cont mb-5">
                    <x-product-card num="1" />
                    <x-product-card num="2" />
                    <x-product-card num="3" />
                    <x-product-card num="4" />
                    <x-product-card num="5" />
                    <x-product-card num="6" />
                    <x-product-card num="7" />
                    <x-product-card num="8" />
                    <x-product-card num="9" />
                    <x-product-card num="10" />
                    <x-product-card num="11" />
                </div>


                <p class="small grey-text">
                    {{ __('pagination.shown', ['start' => 1, 'end' => 12, 'total' => 18]) }}
                </p>

                <nav class="mb-0" id="pagination">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <span class="page-link">&lsaquo;</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link dark-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link dark-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link dark-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link dark-link" href="#" rel="next">&rsaquo;</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>


        <h3>{{ __('catalog.recent') }}</h3>

        <div class="swiper product-carousel">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><x-product-card num="1" /></div>
                <div class="swiper-slide"><x-product-card num="2" /></div>
                <div class="swiper-slide"><x-product-card num="3" /></div>
                <div class="swiper-slide"><x-product-card num="4" /></div>
                <div class="swiper-slide"><x-product-card num="5" /></div>
                <div class="swiper-slide"><x-product-card num="6" /></div>
                <div class="swiper-slide"><x-product-card num="7" /></div>
                <div class="swiper-slide"><x-product-card num="8" /></div>
                <div class="swiper-slide"><x-product-card num="9" /></div>
            </div>
            <div class="carousel-next-btn">
                <span class="icon-chevron-right"></span>
            </div>
            <div class="carousel-prev-btn">
                <span class="icon-chevron-left"></span>
            </div>
        </div>

    </div>
@endsection