<div class="product-compare-btn {{ $active ? 'active' : '' }}"
     data-id="{{ $id }}"
     data-catid="{{ $catid }}"
     {!! $active ? 'title="' . __('comparison.remove_title') . '"' : '' !!}>
    {{--<span class="compare-btn-icon {{ $active ? 'icon-bar-chart-fill' : 'icon-bar-chart' }}"></span>
    <span class="compare-btn-text">{{ $active ? __('comparison.in_list') : __('comparison.compare') }}</span>--}}

    <div class="compare-btn-icon">
        <svg><use href="#productBtnCompareIcon" /></svg>
    </div>
    <div class="compare-btn-text">{{ $active ? __('comparison.in_list') : __('comparison.compare') }}</div>
</div>