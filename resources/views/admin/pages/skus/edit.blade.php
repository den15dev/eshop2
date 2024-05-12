@extends('admin.layout')

@section('page_title',  __('admin/products.editing_sku') . ' ' . $sku->id . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/products.editing_sku'))

@section('main_content')
    <div>
        SKU {{ $sku->id }} editing
    </div>
@endsection