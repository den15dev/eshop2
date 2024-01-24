@extends('site.layout')

@section('page_title', 'JSONB Test')

@section('main_content')
    <div class="container">
        <div>
            <span class="lightgrey-text">Locale:</span> {{ $locale }}
        </div>
        <div class="mb-3">
            <span class="lightgrey-text">Search string:</span> {{ $search_str }}
        </div>

        @if($products_jsonb->count())
            <h5>Got from JSONB:</h5>

            @foreach($products_jsonb as $product)
                <div class="small mb-3">
                    <div>{{ $product->name }}</div>
                    <div>{{ $product->price }}</div>
                    <div class="lightgrey-text">{{ $product->short_descr }}</div>
                </div>
            @endforeach
        @else
            <div class="lightgrey-text">No products found in JSONB</div>
        @endif


        @if($products_flat->count())
            <h5>Got from flat table:</h5>

            @foreach($products_flat as $product)
                <div class="small mb-3">
                    <div>{{ $product->name }}</div>
                    <div>{{ $product->price }}</div>
                    <div class="lightgrey-text">{{ $product->short_descr }}</div>
                </div>
            @endforeach
        @else
            <div class="lightgrey-text">No products found in flat table</div>
        @endif
    </div>
@endsection