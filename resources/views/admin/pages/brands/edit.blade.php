@extends('admin.layout')

@section('page_title',  __('admin/brands.editing_brand') . ' ' . $brand->id . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/brands.editing_brand'))

@section('main_content')
    <div>
        Brand {{ $brand->id }} editing
    </div>
@endsection