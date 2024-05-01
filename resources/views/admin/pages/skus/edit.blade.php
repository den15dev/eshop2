@extends('admin.layout')

@section('page_title',  __('admin/products.sku_editing') . ' ' . $sku->id . ' - ' . __('admin/layout.admin_panel'))

@section('page_header', __('admin/products.sku_editing'))

@section('main_content')
    <div>
        SKU {{ $sku->id }} editing
    </div>
@endsection