@php
    $class_list = 'rating-stars';
    if (isset($mb)) $class_list .= ' mb-' . $mb;
    if ($size === 'small') $class_list .= ' small';
@endphp

@if($product->vote_num > 0)
    @php
        $url = route('reviews', [$product->category_slug, $product->slug . '-' . $product->id]);
    @endphp
    <a href="{{ $url }}" class="{{ $class_list }}" title="{{ $product->rating }}">
        <ul>
            @for($i=0; $i<5; $i++)
                @if($product->rating - $i > 0.75)
                    <li class="icon-star-fill"></li>
                @elseif($product->rating - $i > 0.25)
                    <li class="icon-star-half"></li>
                @else
                    <li class="icon-star"></li>
                @endif
            @endfor
        </ul>
        <div class="vote-num">({{ $product->vote_num }})</div>
    </a>
@else
    <div class="{{ $class_list }}" title="Нет оценок">
        <ul>
            @for($i=0; $i<5; $i++)
            <li class="icon-star"></li>
            @endfor
        </ul>
    </div>
@endif