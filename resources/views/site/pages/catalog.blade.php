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
                <div class="catalog-layout-cont mb-25">
                    <div class="sort-cont dropdown">
                        <div class="dropdown-btn">
                            {{ __('catalog.layout_settings.sort.cheap') }}
                            <span class="icon-chevron-down xsmall"></span>
                        </div>
                        <ul class="dropdown-list">
                            <li>
                                <div>
                                    {{ __('catalog.layout_settings.sort.expensive') }}
                                </div>
                            </li>
                            <li>
                                <div>
                                    {{ __('catalog.layout_settings.sort.new') }}
                                </div>
                            </li>
                            <li>
                                <div>
                                    {{ __('catalog.layout_settings.sort.popular') }}
                                </div>
                            </li>
                            <li>
                                <div>
                                    {{ __('catalog.layout_settings.sort.discounted') }}
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="settings-cont">
                        <div class="dropdown">
                            <div class="dropdown-btn">
                                <span class="sm">{{ __('catalog.layout_settings.on_page') }} </span>12
                                <span class="icon-chevron-down xsmall"></span>
                            </div>
                            <ul class="dropdown-list dd-right">
                                <li>
                                    <div>24</div>
                                </li>
                                <li>
                                    <div>36</div>
                                </li>
                                <li>
                                    <div>48</div>
                                </li>
                            </ul>
                        </div>

                        <svg width="2" height="2" style="display: none">
                            <symbol viewBox="0 0 22 22" id="catalogGrid">
                                <path d="M13.2222 20.3333V13.8889C13.2222 13.5207 13.5207 13.2222 13.8889 13.2222H20.3333C20.7015 13.2222 21 13.5207 21 13.8889V20.3333C21 20.7015 20.7015 21 20.3333 21H13.8889C13.5207 21 13.2222 20.7015 13.2222 20.3333Z" />
                                <path d="M1 20.3333V13.8889C1 13.5207 1.29848 13.2222 1.66667 13.2222H8.11111C8.4793 13.2222 8.77778 13.5207 8.77778 13.8889V20.3333C8.77778 20.7015 8.4793 21 8.11111 21H1.66667C1.29848 21 1 20.7015 1 20.3333Z" />
                                <path d="M13.2222 8.11111V1.66667C13.2222 1.29848 13.5207 1 13.8889 1H20.3333C20.7015 1 21 1.29848 21 1.66667V8.11111C21 8.4793 20.7015 8.77778 20.3333 8.77778H13.8889C13.5207 8.77778 13.2222 8.4793 13.2222 8.11111Z" />
                                <path d="M1 8.11111V1.66667C1 1.29848 1.29848 1 1.66667 1H8.11111C8.4793 1 8.77778 1.29848 8.77778 1.66667V8.11111C8.77778 8.4793 8.4793 8.77778 8.11111 8.77778H1.66667C1.29848 8.77778 1 8.4793 1 8.11111Z" />
                            </symbol>

                            <symbol viewBox="0 0 23 18" id="catalogList">
                                <path d="M6.34036 1.73901H21.3404" />
                                <path d="M1.34036 1.75206L1.35334 1.73764" />
                                <path d="M1.34036 9.25205L1.35334 9.23764" />
                                <path d="M1.34036 16.752L1.35334 16.7376" />
                                <path d="M6.34036 9.239H21.3404" />
                                <path d="M6.34036 16.739H21.3404" />
                            </symbol>
                        </svg>

                        <div class="btn-icon active" id="catalogLayoutGrid">
                            <svg viewBox="0 0 22 22">
                                <use href="#catalogGrid"/>
                            </svg>
                        </div>
                        <div class="btn-icon" id="catalogLayoutList">
                            <svg viewBox="0 0 23 18">
                                <use href="#catalogList"/>
                            </svg>
                        </div>
                    </div>
                </div>


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