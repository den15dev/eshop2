<form class="reviews-form mb-6" method="POST" action="{{ route('reviews.add', [$sku->category_slug, $sku->slug . '-' . $sku->id]) }}">
    @csrf
    <h4 class="mb-3">{{ __('reviews.form.title') }}</h4>

    @if($errors->any())
        <div class="alert alert-warning p-25 my-4" role="alert">
            <ul class="text-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

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
    <input type="hidden" name="sku_id" value="{{ $sku->id }}" />

    <div class="mb-3">
        <label for="termOfUseSelect" class="form-label">{{ __('reviews.form.term') }}:</label>
        @php
            $termOfUse = \App\Modules\Reviews\Enums\TermOfUse::class;
        @endphp
        <select class="form-select" name="term" aria-label="{{ __('reviews.form.title') }}" id="termOfUseSelect">
            <option value="{{ $termOfUse::Days->value }}" selected>{{ $termOfUse::Days->description() }}</option>
            <option value="{{ $termOfUse::Weeks->value }}">{{ $termOfUse::Weeks->description() }}</option>
            <option value="{{ $termOfUse::Months->value }}">{{ $termOfUse::Months->description() }}</option>
            <option value="{{ $termOfUse::Years->value }}">{{ $termOfUse::Years->description() }}</option>
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
        <textarea class="form-control" name="comnt" id="commentTextArea" placeholder="{{ __('reviews.form.optional') }}">{{ old('comment') }}</textarea>
    </div>

    <button type="submit">{{ __('reviews.form.send') }}</button>
</form>
