@extends('admin.layout')

@section('page_title',  __('admin/users.users') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/users.users'))

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
                <input type="checkbox" class="form-check-input" name="chb[banned]" id="userBanned" {{ $state->banned ? 'checked' : '' }} />
                <label class="form-check-label" for="userBanned">{{ __('admin/users.checkboxes.banned') }}</label>
            </div>

            <div class="index_checkbox-cont">
                <input type="checkbox" class="form-check-input" name="chb[admins]" id="userAdmin" {{ $state->admins ? 'checked' : '' }} />
                <label class="form-check-label" for="userAdmin">{{ __('admin/users.checkboxes.admins') }}</label>
            </div>
        </div>

        <div id="indexTableCont" data-name="{{ $table_name }}">
            @include('admin.includes.index-table')
        </div>
    </div>
@endsection