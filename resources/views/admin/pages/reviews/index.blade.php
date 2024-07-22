@extends('admin.layout')

@section('page_title',  __('admin/reviews.reviews') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/reviews.reviews'))

@section('main_content')
    <div>
        <div class="index_search-add mb-3">
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