@extends('admin.layout')

@section('page_title',  __('admin/orders.orders') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/orders.orders'))

@section('main_content')
    <div>
        <div class="index_search-add mb-3">
            <div class="index_search">
                <input type="text" class="form-control" name="search" placeholder="{{ __('admin/index-page.search') }}" value="{{ $state->search }}" id="searchInput" />
                <div class="icon-x-lg index_search_close-btn {{ $state->search ? '' : 'hidden' }}"></div>
            </div>
        </div>

        <div class="index_checkboxes mb-4">
            <div class="index_checkbox-cont">
                <input type="checkbox" class="form-check-input" name="chb[new]" id="productsActive" {{ $state->new ? 'checked' : '' }} />
                <label class="form-check-label" for="productsActive">{{ __('admin/orders.statuses.new') }}</label>
            </div>

            <div class="index_checkbox-cont">
                <input type="checkbox" class="form-check-input" name="chb[ready]" id="productsOutOfStock" {{ $state->ready ? 'checked' : '' }} />
                <label class="form-check-label" for="productsOutOfStock">{{ __('admin/orders.statuses.ready') }}</label>
            </div>

            <div class="index_checkbox-cont">
                <input type="checkbox" class="form-check-input" name="chb[cancelled]" id="productsScheduled" {{ $state->cancelled ? 'checked' : '' }} />
                <label class="form-check-label" for="productsScheduled">{{ __('admin/orders.statuses.cancelled') }}</label>
            </div>
        </div>

        <div id="indexTableCont" data-name="{{ $table_name }}">
            @include('admin.includes.index-table')
        </div>
    </div>
@endsection
