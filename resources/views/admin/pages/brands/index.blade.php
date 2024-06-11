@extends('admin.layout')

@section('page_title',  __('admin/brands.brands') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/brands.brands'))

@section('main_content')
    <div>
        <div class="index_search-add mb-4">
            <div class="index_search">
                <input type="text" class="form-control" name="search" placeholder="{{ __('admin/index-page.search') }}" value="{{ $state->search }}" id="searchInput" />
                <div class="icon-x-lg index_search_close-btn {{ $state->search ? '' : 'hidden' }}"></div>
            </div>
            <div class="index_add-btn">
                <a href="#" class="btn btn-add">{{ __('admin/brands.add_brand') }}</a>
            </div>
        </div>

        <div id="indexTableCont" data-name="{{ $table_name }}">
            @include('admin.includes.index-table')
        </div>
    </div>
@endsection