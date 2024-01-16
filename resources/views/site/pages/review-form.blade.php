<form class="reviews-form mb-6" method="POST" action="{{ route('reviews.add', [$product->category_slug, $product->slug . '-' . $product->id]) }}">
    @csrf
    <h4 class="mb-3">{{ __('reviews.form.title') }}</h4>

    <div class="mb-3">
        <ul class="rating-stars rate">
            <li class="icon-star"></li>
            <li class="icon-star"></li>
            <li class="icon-star"></li>
            <li class="icon-star"></li>
            <li class="icon-star"></li>
        </ul>
        <div class="invalid-cont">
            <span class="icon-arrow-up me-1"></span>
            {{ __('reviews.please_rate') }}
        </div>
    </div>

    <input type="hidden" name="mark" value="{{ old('mark') }}" id="rateInput"/>
    <input type="hidden" name="product_id" value="{{ $product->id }}" />

    <div class="mb-3">
        <label for="termOfUseSelect" class="form-label">{{ __('reviews.form.term') }}:</label>
        <select class="form-select" aria-label="{{ __('reviews.form.title') }}" id="termOfUseSelect">
            <option value="days" selected>{{ __('reviews.term.days') }}</option>
            <option value="weeks">{{ __('reviews.term.weeks') }}</option>
            <option value="months">{{ __('reviews.term.months') }}</option>
            <option value="years">{{ __('reviews.term.years') }}</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="prosTextArea" class="form-label">{{ __('reviews.pros') }}:</label>
        <textarea class="form-control" name="pros" id="prosTextArea" placeholder="{{ __('reviews.form.optional') }}">{{ old('pros') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="consTextArea" class="form-label">{{ __('reviews.cons') }}:</label>
        <textarea class="form-control" name="cons" id="consTextArea" placeholder="{{ __('reviews.form.optional') }}">{{ old('cons') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="commentTextArea" class="form-label">{{ __('reviews.comment') }}:</label>
        <textarea class="form-control" name="comment" id="commentTextArea" placeholder="{{ __('reviews.form.optional') }}">{{ old('comment') }}</textarea>
    </div>

    <button type="submit">{{ __('reviews.form.send') }}</button>
</form>