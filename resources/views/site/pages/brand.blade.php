@extends('site.layout')

@section('page_title', $brand->name . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <div class="brand_image-cont mt-2 mb-4">
            <img src="{{ $brand->image_url }}" alt="{{ $brand->name }}">
        </div>

        <div class="brand_descr-cont mb-5">
            {!! to_paragraphs($brand->description) !!}
        </div>

        @if($brand_categories->count())
            <h4 class="mb-4">{{ __('brand.products_in_categories', ['brand' => $brand->name]) }}</h4>

            <div class="catalog-cards-cont mb-5">
                @foreach($brand_categories as $category)
                    <x-category-card :category="$category"
                                     :skunum="$category->sku_num"
                                     :url="route('catalog', ['category' => $category->slug, 'brands[0]' => $brand->id])" />
                @endforeach
            </div>
        @endif
    </div>
@endsection