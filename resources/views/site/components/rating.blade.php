@php
    $class_list = 'rating';
    if (isset($mb)) $class_list .= ' mb-' . $mb;
    if (isset($size) && $size === 'small') $class_list .= ' small';
@endphp

@if($num > 0)
    @if(isset($url))
        <a href="{{ $url }}" class="{{ $class_list }}" title="{{ $rating }}">
            <x-stars :rating="$rating" />
            <div class="vote-num">({{ $num }})</div>
        </a>
    @else
        <div class="{{ $class_list }}" title="{{ $rating }}">
            <x-stars :rating="$rating" />
            <div class="vote-num">({{ $num }})</div>
        </div>
    @endif
@else
    <div class="{{ $class_list }}" title="{{ __('product.no_marks') }}">
        <x-stars rating="0" />
    </div>
@endif