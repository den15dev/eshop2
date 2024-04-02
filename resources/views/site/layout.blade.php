<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('page_title', __('general.app_name'))</title>

    @include('site.main.meta-tags')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{ Vite::useHotFile('site.hot')
        ->useBuildDirectory('build')
        ->withEntryPoints(['resources/css/app.scss', 'resources/js/app.js']) }}
</head>
<body>
@include('site.main.svg')

<div class="page-wrap">
    @include('site.main.header')

    <main>
        @yield('main_content')
    </main>

    @include('site.main.footer')
</div>

@include('site.main.bottom-nav')

<div class="page-tint"></div>
<div class="modal-tint"></div>

@guest
    @include('site.auth.auth-modal')
@endguest

@include('common.modal-client')

{{-- ----- Flash message ----- --}}
@if(session()->has('message'))
    <x-modal-flash
            type="{{ session('message.type') }}"
            content="{!! session('message.content') !!}"
            align="{{ session('message.align') }}"/>
@endif

{{-- ----- Comparison popup ----- --}}
@unless(request()->routeIs('comparison'))
    @if($comparison_skus->count())
        <div class="comparison-popup {{ $is_popup_collapsed ? 'collapsed' : '' }}">
            @include('site.includes.comparison-popup')
        </div>
    @else
        <div class="comparison-popup" style="display: none"></div>
    @endif
@endunless

{{-- ----- Monitoring page load time and number of DB queries ----- --}}
@include('common.monitor')

@stack('scripts')
</body>
</html>
