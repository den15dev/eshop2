<div class="filters_price-cont px-3">
    <div>{{ __('filters.from') }}</div>
    <div>
        <input type="text" class="form-control form-control-sm" name="price_min" value="" placeholder="{{ $range[0] }}"/> руб
    </div>
    <div>{{ __('filters.to') }}</div>
    <div>
        <input type="text" class="form-control form-control-sm" name="price_max" value="" placeholder="{{ $range[1] }}"/> руб
    </div>
</div>