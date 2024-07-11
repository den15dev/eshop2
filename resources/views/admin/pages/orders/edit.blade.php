@extends('admin.layout')

@section('page_title',  __('admin/orders.order_managing') . ' ' . $order->id . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/orders.order_managing'))

@section('main_content')
    <div>
        <div class="mb-3">
            <span class="grey-text">ID {{ $order->id }}:</span> {{ $order->name }}
        </div>
    </div>
@endsection