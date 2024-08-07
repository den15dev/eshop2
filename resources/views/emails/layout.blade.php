<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page_title', __('general.app_name'))</title>
</head>
<body style="margin: 0; background-color: #f1f0f6; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 16px; color: #424242; line-height: 1.5;">
<div style="width: 600px; margin: 0 auto 24px auto; padding: 30px; background-color: white">
    <a href="{{ $home_url }}" style="display: block; width: 160px; margin: 0 auto 32px auto;">
        <img src="{{ asset('img/logo/' . $logo) }}" alt="{{ __('general.app_name') }}" style="display: block; width: 100%;">
    </a>

    @yield('main_content')
</div>
<p style="width: 600px; margin: 0 auto 24px auto; text-align: center; font-size: 12px; color: #b4b4b4;">@yield('footer')</p>
<p style="width: 600px; margin: 0 auto 0 auto; padding-bottom: 24px; text-align: center; font-size: 12px; color: #b4b4b4;">&copy; {{ date('Y') }} {{ __('notifications.copyright') }}</p>
</body>
</html>