@extends('site.layout')

@section('page_title', $category->name . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <x-breadcrumb :breadcrumb="$breadcrumb"/>

        <div class="catalog-cards-cont mb-5">
            @foreach($children as $child)
                <x-category-card :category="$child" />
            @endforeach
        </div>
    </div>
@endsection