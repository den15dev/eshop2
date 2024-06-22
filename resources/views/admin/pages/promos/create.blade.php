@extends('admin.layout')

@section('page_title',  __('admin/promos.adding_promo') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/promos.adding_promo'))

@section('main_content')
    <div class="admin-main-page">
        <form class="mb-55" enctype="multipart/form-data" action="{{ route('admin.promos.store') }}" method="POST">
            @csrf
            
            <button type="submit">{{ __('admin/general.create') }}</button>
        </form>
    </div>
@endsection