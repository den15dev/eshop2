@extends('admin.layout')

@section('page_title',  $category->name . ' - ' . __('admin/categories.editing_category'))

@section('page_header', __('admin/categories.editing_category'))

@section('main_content')
    <div class="admin-main-page">
        Editing the category "{{ $category->name }}"
    </div>
@endsection