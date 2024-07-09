@extends('site.layout')

@section('page_title', $promo->name . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h3 class="mb-3">{{ $promo->name }}</h3>

        @php
            $starts_at = \Carbon\Carbon::parse($promo->starts_at);
            $ends_at = \Carbon\Carbon::parse($promo->ends_at);
        @endphp
        <div class="mb-4">
            @if($ends_at->isPast())
                <div class="promo_inactive_badge">
                    {{ __('promo.completed') }}
                </div>
            @else
                <div class="grey-text">
                    {{ __('promo.dates', ['start' => $starts_at->isoFormat('LL'), 'end' => $ends_at->isoFormat('LL')]) }}
                </div>
            @endif
        </div>

        <div class="promo-image-cont mb-5">
            <picture>
                <source srcset="{{ $promo->getImageURL('xxl') }}" media="(min-width: {{ $promo::IMG_SIZES['xl'] }}px)"/>
                <source srcset="{{ $promo->getImageURL('xl') }}" media="(min-width: {{ $promo::IMG_SIZES['lg'] }}px)"/>
                <source srcset="{{ $promo->getImageURL('lg') }}" media="(min-width: {{ $promo::IMG_SIZES['md'] }}px)"/>
                <img src="{{ $promo->getImageURL('md') }}" alt=""/>
            </picture>
        </div>

        <p class="mb-5">{{ $promo->description }}</p>

        @if($skus->count())
            <h4 class="mb-5">{{ __('promo.products') }}</h4>

            <div class="catalog-cards-cont mb-5">
                @foreach($skus as $sku)
                    <x-product-card :sku="$sku" page="promo"/>
                @endforeach
            </div>
        @endif
    </div>
@endsection