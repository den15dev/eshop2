@extends('site.layout')

@section('page_title', $category->name . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <div>
            Category: {{ $category->name }}
        </div>
        <div>
            @foreach($children as $child)
                {{ $child->name }} ({{ $child->product_count }})<br>
            @endforeach
        </div>
    </div>
@endsection