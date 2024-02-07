@extends('site.layout')

@section('page_title', __('comparison.product_comparison') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h3 class="mb-3">{{ __('comparison.product_comparison') }}</h3>

        @if($comparison_products->count())
            <div class="comparison-table_cont mb-6">
                <table class="table comparison-table">
                    <thead>
                    <tr>
                        <td class="comparison-table_col1">
                            <div class="comparison-table_clear-btn link">
                                <span class="icon-x me-1"></span>{{ __('comparison.clear') }}
                            </div>
                        </td>
                        @foreach($comparison_products as $product)
                            <td class="comparison-table_col">
                                <div class="comparison-table_remove-btn link mb-2" data-id="{{ $product->id }}">
                                    <span class="icon-x me-1"></span>{{ __('comparison.remove') }}
                                </div>
                                <a href="{{ $product->url }}" class="comparison-table_img-link mb-2">
                                    <img src="{{ asset('storage/images/products/' . (($product->id - 1) % 4 + 1) . '/01_80.jpg') }}" alt="">
                                </a>
                                <a href="{{ $product->url }}" class="comparison-table_name dark-link mb-2">
                                    {{ $product->name }}
                                </a>
                                <div class="grey-text mb-1">
                                    {{ number_format($product->final_price, 0, ',', ' ') }} ₽
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specs as $spec)
                        <tr>
                            <td>{{ $spec->name }}</td>

                            @foreach($comparison_products as $product)
                                <td>{{ $product->specifications->firstWhere('id', $spec->id)?->pivot->spec_value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="items-not-found">{{ __('comparison.empty') }}</div>
        @endif

        @if($recently_viewed->count())
            @include('site.includes.recently-viewed')
        @endif
    </div>
@endsection