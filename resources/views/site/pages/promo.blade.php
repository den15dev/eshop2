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
                @if($starts_at->year === $ends_at->year)
                    {{ __('promo.dates_same_year', ['start' => $starts_at->isoFormat('D MMMM'), 'end' => $ends_at->isoFormat('D MMMM YYYY')]) }}
                @else
                    {{ __('promo.dates_next_year', ['start' => $starts_at->isoFormat('D MMMM YYYY'), 'end' => $ends_at->isoFormat('D MMMM YYYY')]) }}
                @endif
            </div>
        @endif
        </div>

        <div class="promo-image-cont mb-4">
            <picture>
                <source srcset="{{ $promo->images->size_1296 }}" media="(min-width: 1140px)" />
                <source srcset="{{ $promo->images->size_1140 }}" media="(min-width: 992px)" />
                <source srcset="{{ $promo->images->size_992 }}" media="(min-width: 768px)" />
                <img src="{{ $promo->images->size_788 }}" alt="" />
            </picture>
        </div>

        <p class="mb-5">{{ $promo->description }}</p>

        @if($products->count())
            <h4 class="mb-4">{{ __('promo.products') }}</h4>

            <div class="catalog-cards-cont mb-5">
                @foreach($products as $product)
                    <x-product-card :product="$product"/>
                @endforeach
            </div>
        @endif
    </div>
@endsection