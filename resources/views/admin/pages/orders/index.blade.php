@extends('admin.layout')

@section('page_title',  __('admin/orders.orders') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/orders.orders'))

@section('main_content')
    <div>
        <div class="index_search-add mb-4">
            <div class="index_search">
                <input type="text" class="form-control" name="search" placeholder="{{ __('admin/index-page.search') }}" value="{{ $state->search }}" id="searchInput" />
                <div class="icon-x-lg index_search_close-btn {{ $state->search ? '' : 'hidden' }}"></div>
            </div>
        </div>

        <div id="indexTableCont" data-name="{{ $table_name }}">
            @include('admin.includes.index-table')
        </div>
    </div>
@endsection