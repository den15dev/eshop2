@php
    $class_list = 'rating-stars';
    if (isset($size)) {
        $class_list .= ' ' . $size;
    }
    if (isset($mb)) {
        $class_list .= ' ' . 'mb-' . $mb;
    }
@endphp
<ul class="{{ $class_list }}">
    @for($i=0; $i<5; $i++)
        @if($rating - $i > 0.75)
            <li class="icon-star-fill"></li>
        @elseif($rating - $i > 0.25)
            <li class="icon-star-half"></li>
        @else
            <li class="icon-star"></li>
        @endif
    @endfor
</ul>