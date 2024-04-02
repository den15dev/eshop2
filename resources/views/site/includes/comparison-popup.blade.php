<div id="comparisonContent">
    <div class="comparison-popup_head" data-collapsed="{{ $is_popup_collapsed ? 'on' : 'off' }}">
        <div class="comparison-popup_head-cont">
            <div class="comparison-popup_head-title">{{ __('comparison.product_comparison') }}</div>
            <span class="comparison-popup_head-count">({{ $comparison_skus->count() }})</span>
        </div>
        <div class="btn-icon me-2">
            <span class="icon-chevron-{{ $is_popup_collapsed ? 'up' : 'down' }}"></span>
        </div>
    </div>

    <div class="comparison-popup_body" {!! $is_popup_collapsed ? 'style="display:none;"' : '' !!}>
        <div class="comparison-popup_list">
            @foreach($comparison_skus as $sku)
                <x-comparison-popup-item :sku="$sku" />
            @endforeach
        </div>

        <div class="comparison-popup_btns">
            <a href="{{ route('comparison') }}" class="btn-link link">{{ __('comparison.compare') }}</a>
            <div class="btn-link link" id="comparisonPopupClearBtn">{{ __('comparison.clear_list') }}</div>
        </div>
    </div>
</div>