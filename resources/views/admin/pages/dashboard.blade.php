@extends('admin.layout')

@section('page_title',  __('admin/dashboard.dashboard') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/dashboard.dashboard'))

@section('main_content')
    <div id="dashboardPage">
        <div class="dashboard-select_cont mb-2">
            <div class="dashboard-select_period">
                <select name="period" class="form-select" id="dashboardPeriod">
                    @foreach($years as $year)
                        <option value="{{ $year->value }}" @selected($state->period === $year->value)>{{ $year->text }}</option>
                    @endforeach
                </select>
            </div>
            <div class="dashboard-select_category">
                <select name="category" class="form-select" id="dashboardCategory">
                    <option value="">{{ __('admin/dashboard.all_categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                                @if($category->level === 1) class="fw-bold" @endif
                                @selected($state->category === $category->id)>
                            {{ str_repeat('-', $category->level - 1) . ' ' . $category->name }} ({{ $category->sku_num_children_all ?: $category->sku_num_all }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="dashboard-select_currency">
                <select name="currency" class="form-select" id="dashboardCurrency">
                    @foreach($currencies as $currency)
                        <option value="{{ $currency->value }}" data-symbol="{!! $currency->symbol !!}" @selected($state->currency === $currency->value)>
                            {{ $currency->text }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="dashboard_reset-btn small link" id="resetFiltersBtn">{{ __('admin/dashboard.reset_filters') }}</div>

        <div class="mb-4">
            <x-admin::dashboard-chart id="salesAmountChart"
                                      :title="__('admin/dashboard.sales_amount')"
                                      :currency="$currencies[0]->symbol" />

            <x-admin::dashboard-chart id="ordersCountChart" :title="__('admin/dashboard.orders_count')" />
            <x-admin::dashboard-chart id="skusAddedCountChart" :title="__('admin/dashboard.skus_added')" />
            <x-admin::dashboard-chart id="reviewsAddedCountChart" :title="__('admin/dashboard.reviews_added')" />
            <x-admin::dashboard-chart id="registeredUsersCountChart" :title="__('admin/dashboard.users_registered')" />
        </div>

        <script>
            let chartsData = {!! json_encode($charts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
        </script>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush