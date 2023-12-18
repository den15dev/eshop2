<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('page_title', __('general.app_name'))</title>

    @include('site.main.meta-tags')

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

@guest
    @include('site.auth.auth-modal')
@endguest

@if(session()->has('message'))
    <x-flash-modal
            type="{{ session('message.type') }}"
            content="{!! session('message.content') !!}"
            align="{{ session('message.align') }}" />
@endif

@include('common.monitor')
</body>
</html>
