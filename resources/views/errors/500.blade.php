<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ __('errors.500') }}</title>

    @include('site.main.meta-tags')

    {{ Vite::useHotFile('site.hot')
        ->useBuildDirectory('build')
        ->withEntryPoints(['resources/css/app.scss']) }}
</head>
<body>
    <div class="http-error-cont error-500">
        {{ __('errors.500') }}
    </div>
</body>
</html>
