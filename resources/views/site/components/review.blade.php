<div class="review-cont">
    <div class="review-id-cont">#{{ $review->id }}</div>

    <div class="review-name-cont mb-2">
        @if($review->user->image)
            <img src="{{ $review->user->thumbnail_url }}" class="review-avatar" alt="" />
        @else
            <svg class="review-avatar"><use href="#userGreyAvatar"/></svg>
        @endif

        <div class="review-name">{{ $review->user->name }}</div>
    </div>

    <div class="mb-3">
        <x-stars size="small" mb="1" :rating="$review->mark" />
        <div class="grey-text" title="{{ $review->date }}">{{ $review->human_date }}</div>
        <div>
            <span class="grey-text">{{ __('reviews.term_of_use') }}:</span> {{ $review->term->description() }}
        </div>
    </div>

    @if($review->pros)
        <div class="review-text-block">
            <div>{{ __('reviews.pros') }}</div>
            <p>{{ $review->pros }}</p>
        </div>
    @endif

    @if($review->cons)
        <div class="review-text-block">
            <div>{{ __('reviews.cons') }}</div>
            <p>{{ $review->cons }}</p>
        </div>
    @endif

    @if($review->comnt)
        <div class="review-text-block">
            <div>{{ __('reviews.comment') }}</div>
            <p>{{ $review->comnt }}</p>
        </div>
    @endif

    <div class="review-reactions" data-id="{{ $review->id }}">
        <div class="review-reactions_up @if($reactionsoff) disabled @endif {{ $review->user_likes ? 'active' : '' }}">
            <div class="review-reactions_icon"></div>
            <div class="review-reactions_number">{{ $review->likes }}</div>
        </div>
        <div class="review-reactions_down @if($reactionsoff) disabled @endif {{ $review->user_dislikes ? 'active' : '' }}">
            <div class="review-reactions_icon"></div>
            <div class="review-reactions_number">{{ $review->dislikes }}</div>
        </div>
    </div>
</div>