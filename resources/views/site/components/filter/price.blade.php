<div class="filters_price-cont px-3">
    <div>{!! __('filters.from') . ' ' . ($range->is_precedes ? $range->symbol : '') !!}</div>
    <div>
        <input type="text" class="form-control form-control-sm" name="price_min" value="{{ request('price_min') }}" placeholder="{{ $range->min }}"/> {!! $range->is_precedes ? '' : $range->symbol !!}
    </div>
    <div>{!! __('filters.to') . ' ' . ($range->is_precedes ? $range->symbol : '') !!}</div>
    <div>
        <input type="text" class="form-control form-control-sm" name="price_max" value="{{ request('price_max') }}" placeholder="{{ $range->max }}"/> {!! $range->is_precedes ? '' : $range->symbol !!}
    </div>
</div>