@extends('admin.layout')

@section('page_title',  __('admin/products.product_editing') . ' ' . $product->id . ' - ' . __('admin/layout.admin_panel'))

@section('page_header', __('admin/products.product_editing'))

@section('main_content')
    <div>
        Product {{ $product->id }} editing
    </div>
@endsection