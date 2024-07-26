@extends('admin.layout')

@section('page_title',  __('admin/shops.shops') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/shops.shops'))

@section('main_content')
    <div>
        <div class="index_search-add mb-3">
            <div class="index_search">
                <input type="text" class="form-control" name="search" placeholder="{{ __('admin/index-page.search') }}" value="{{ $state->search }}" id="searchInput" />
                <div class="icon-x-lg index_search_close-btn {{ $state->search ? '' : 'hidden' }}"></div>
            </div>
            <div class="index_add-btn">
                <a href="{{ route('admin.shops.create') }}" class="btn btn-add">{{ __('admin/shops.add_shop') }}</a>
            </div>
        </div>

        <div class="index_checkboxes mb-4">
            <div class="index_checkbox-cont">
                <input type="checkbox" class="form-check-input" name="chb[active]" id="shopsActive" {{ $state->active ? 'checked' : '' }} />
                <label class="form-check-label" for="shopsActive">{{ __('admin/shops.checkboxes.active') }}</label>
            </div>

            <div class="index_checkbox-cont">
                <input type="checkbox" class="form-check-input" name="chb[inactive]" id="shopsInactive" {{ $state->inactive ? 'checked' : '' }} />
                <label class="form-check-label" for="shopsInactive">{{ __('admin/shops.checkboxes.inactive') }}</label>
            </div>
        </div>

        <div id="indexTableCont" data-name="{{ $table_name }}">
            @include('admin.includes.index-table')
        </div>
    </div>
@endsection