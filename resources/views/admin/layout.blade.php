<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {{ Vite::useHotFile('admin.hot')
        ->useBuildDirectory('admin')
        ->withEntryPoints(['resources/css/admin.scss', 'resources/js/admin.js']) }}
</head>
<body>
    <div class="page-wrap">
        <header>
            Header
        </header>

        <main>
            @yield('main_content')
        </main>

        <footer>
            Footer
        </footer>
    </div>

    <div class="main-tint"></div>
    <div class="win-tint"></div>
</body>
</html>