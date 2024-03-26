@php
    $class = isset($type) && $type === 'mobile' ? 'reviews-rating-cont-mobile mb-45' : 'reviews-rating-cont';
@endphp

<div class="{{ $class }}">
    <div class="reviews-rating-total">
        @if($rating)
            <div class="total-mark">{{ $ratingformatted }}</div>
            <x-rating :rating="$rating"
                      :ratingformatted="$ratingformatted"
                      :num="$num"/>
        @else
            <div class="no-marks">{{ __('reviews.no_marks') }}</div>
        @endif
    </div>

    <table>
        <tbody>
        @for($i=5; $i>0; $i--)
            <x-rating-bar :mark="$i" :num="$marks ? $marks[$i - 1] : 0" :max="$max" />
        @endfor
        </tbody>
    </table>
</div>