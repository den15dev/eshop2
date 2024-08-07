@extends('site.layout')

@section('page_title', __('orders.orders') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h3 class="mb-4">{{ __('orders.orders') }}</h3>

        @if($orders && $orders->count())
            @foreach($orders as $order)
                <x-order :order="$order" />
            @endforeach

            @if($orders->hasPages())
                <div class="mb-5">
                    {{ $orders->links('common.pagination.results-shown') }}
                    {{ $orders->onEachSide(1)->withQueryString()->links('common.pagination.page-links') }}
                </div>
            @endif
        @else
            <div class="items-not-found">
                {{ __('orders.no_orders') }}
            </div>
        @endif

        @if($recently_viewed->count())
            @include('site.includes.recently-viewed')
        @endif
    </div>
@endsection
