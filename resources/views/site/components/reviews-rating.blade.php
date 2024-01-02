@php
    $class = isset($type) && $type === 'mobile' ? 'reviews-rating-cont-mobile mb-45' : 'reviews-rating-cont';
@endphp

<div class="{{ $class }}">
    <div class="reviews-rating-total">
        <div class="total-mark">{{ number_format($rating, 1, ',') }}</div>
        <x-rating :rating="$rating" :num="$num"/>
    </div>

    <table>
        <tbody>
        @for($i=5; $i>0; $i--)
            <x-rating-bar :mark="$i" :num="$marks ? $marks[$i - 1] : 0" :max="$max" />
        @endfor
        </tbody>
    </table>
</div>