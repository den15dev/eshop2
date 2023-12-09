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

        <div class="catalog-page-wrap">
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
                <div class="layout-cont mb-3">
                    <div class="sort-cont">
                        Sort cont
                    </div>
                    <div class="settings-cont">
                        Settings
                    </div>
                </div>

                Для поддержания стабильной работы процессора AMD Ryzen 5 5600X BOX и предупреждения его перегрева, в комплекте с ним предусмотрена система охлаждения и нанесенный на основание радиатора термоинтерфейс.

                <p>
                    {{ app()->getLocale() }}
                </p>
                <p>
                    {{ app()->getFallbackLocale() }}
                </p>
            </div>
        </div>
    </div>
@endsection