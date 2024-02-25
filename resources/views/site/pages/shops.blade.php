@extends('site.layout')

@section('page_title', __('shops.shops') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h3 class="mb-4">{{ __('shops.shops') }}</h3>

        <nav class="shops_tabs tab-cont mb-4">
            <div class="tab-btn active" role="button" id="shopListTab">
                Список
            </div>
            <div class="tab-btn link" role="button" id="shopMapTab">
                Карта
            </div>
        </nav>

        <div class="shops_cont">
            <div class="tab-pane" id="shopMapTabPane">
                <div class="shops_map" id="map"></div>
            </div>

            <div class="tab-pane active" id="shopListTabPane">
                @foreach($shops as $shop)
                    <div class="shops_item" data-shopid="{{ $shop->id }}" data-collapsed="1">
                        <div class="shops_item-name">{{ $shop->name }}</div>
                        <div class="shops_item-address">{{ $shop->address }}</div>
                        <div class="shops_item-hours">
                            @foreach($shop->opening_hours_human as $oh_block)
                                {{ $oh_block }}<br>
                            @endforeach
                        </div>
                        <div class="shops_item-info">{{ $shop->info }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            const shops_data = {!! $shops_json !!};
        </script>
    </div>
@endsection

@push('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?apikey={{ env('YMAP_API_KEY') }}&lang={{ app()->getLocale() }}"></script>
    <script src="{{ asset('js/ymap.js') }}"></script>
@endpush