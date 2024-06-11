@extends('admin.layout')

@section('page_title',  __('admin/categories.creating_category') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/categories.creating_category'))

@section('main_content')
    <div class="admin-main-page">
        Creating a child category for {{ $parent_id }}
    </div>
@endsection