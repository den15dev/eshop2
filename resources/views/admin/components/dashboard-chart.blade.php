<div class="dashboard-chart_item">
    <div class="dashboard-chart_preloader-cont hidden">
        <img src="{{ asset('img/preloader.gif') }}" alt="">
    </div>
    <div class="dashboard-chart_title">
        <span class="main-title">
            {{ $title }}{!! isset($currency) ? ', <span id="salesAmountCurrency">' . $currency . '</span>' : ''  !!}
        </span>
        <span class="lightgrey-text" data-role="total"></span>
    </div>
    <div class="dashboard-chart" id="{{ $id }}"></div>
</div>