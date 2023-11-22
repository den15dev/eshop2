<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title', config('app.name'))</title>

    @include('includes.meta-tags')

    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
    @include('includes.svg')

    <div class="page-wrap">
        @include('includes.header.header')

        <main>
            @yield('main_content')
        </main>

        @include('includes.footer.footer')
        @include('includes.footer.bottom-navigation')
    </div>

    <div class="main-tint"></div>
    <div class="win-tint"></div>
</body>
</html>
