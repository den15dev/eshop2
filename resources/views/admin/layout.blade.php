<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page_title', __('admin/general.admin_panel') . ' - ' . __('general.app_name'))</title>

    <link rel="icon" type="image/png" href="{{ asset('img/41b106e0/adm_icon_16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ asset('img/41b106e0/adm_icon_32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('img/41b106e0/adm_icon_64.png') }}" sizes="64x64">
    <link rel="apple-touch-icon" href="{{ asset('img/41b106e0/adm_icon_76.png') }}" sizes="76x76">
    <link rel="apple-touch-icon" href="{{ asset('img/41b106e0/adm_icon_120.png') }}" sizes="120x120">
    <link rel="apple-touch-icon" href="{{ asset('img/41b106e0/adm_icon_152.png') }}" sizes="152x152">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(env('ADMIN_DEMO'))
    <meta name="submit-403-messages" content="{{ !request()->user()?->isAdmin() }}">
    @endif

    {{ Vite::useHotFile('admin.hot')
        ->useBuildDirectory('admin')
        ->withEntryPoints(['resources/css/admin.scss', 'resources/js/admin.js']) }}
</head>
<body>
    @include('admin.main.svg')

    <div class="page-wrap">
        @include('admin.main.header')

        <main>
            <div class="container">
                <div class="admin-page-wrap">
                    <div class="sidebar-cont">
                        <div class="sidebar-logo">
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-logo_link">
                                <img src="{{ asset('img/logo/logo_en_160.png') }}" alt="{{ __('general.app_name') }}">
                            </a>
                            <div class="sidebar-logo_subtitle">{{ __('admin/general.admin_panel') }}</div>
                        </div>

                        @include('admin.main.navigation')
                    </div>

                    <div class="page-cont">
                        <div class="page-header mb-25">
                            <div class="page-header_title">
                                <h4>@yield('page_header')</h4>
                            </div>
                            <div class="page-header_right">
{{--                                <a href="{{ route('home') }}" class="page-header_site-link grey-link">{{ __('admin/general.go_to_site') }}</a>--}}
                                <x-languages-dropdown type="desktop" :languages="$languages" :curlang="$languages->first()" />
                            </div>
                        </div>

                        @yield('main_content')
                    </div>
                </div>
            </div>
        </main>

        @include('admin.main.footer')
    </div>

    <div class="page-tint"></div>
    <div class="modal-tint"></div>

    @include('common.modal-client')

    {{-- ----- Flash message ----- --}}
    @if(session()->has('message'))
        <x-modal-flash
                type="{{ session('message.type') }}"
                content="{!! session('message.content') !!}"
                align="{{ session('message.align') }}"/>
    @endif

    {{-- ----- Monitoring page load time and number of DB queries ----- --}}
    @include('common.monitor')
</body>
</html>