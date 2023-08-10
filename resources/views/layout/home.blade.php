<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
<svg width="2" height="2" style="display: none">
    <symbol viewBox="0 0 15 14" id="iconList">
        <path d="M1.40381 1.71429H13.5961" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M1.40381 7H13.5961" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M1.40381 12.2857H13.5961" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
</svg>



<div class="page-wrap">
    <header>
        <div class="container">
            <div class="logo">
                <img src="{{ asset('img/logo_ru.svg') }}" alt="logo">
            </div>
            <div class="top-center">
                <div>
                    <a href="#">
                        Top menu
                        <span class="icon-chevron-down xsmall va2"></span>
                    </a>
                </div>
            </div>
            <div class="top-right">Top right</div>
            <div class="bottom-left">
                <button class="catalog-btn">
                    Каталог
                    <svg class="ms-2 va-1"><use href="#iconList" /></svg>
                </button>
            </div>
            <div class="bottom-center">Search input</div>
            <div class="bottom-right">User menu icons go here</div>
        </div>
    </header>


    <main>
        <div class="container">

            <h1>Very big title</h1>
            <div class="mb-4">
                To maintain the stable operation of the AMD Ryzen 5 5600X BOX processor and prevent it from overheating, it comes with a cooling system and a thermal interface applied to the base of the radiator.
                To maintain the stable operation of the AMD Ryzen 5 5600X BOX processor and prevent it from overheating, it comes with a cooling system and a thermal interface applied to the base of the radiator.
            </div>

            <h2>Ещё по-больше</h2>
            <div class="mb-4">
                Для поддержания стабильной работы процессора AMD Ryzen 5 5600X BOX и предупреждения его перегрева, в комплекте с ним предусмотрена система охлаждения и нанесенный на основание радиатора термоинтерфейс.
                Для поддержания стабильной работы процессора AMD Ryzen 5 5600X BOX и предупреждения его перегрева, в комплекте с ним предусмотрена система охлаждения и нанесенный на основание радиатора термоинтерфейс.
            </div>

            <h3>Заголовок чуть больше</h3>
            <div class="mb-4">
                To maintain the stable operation of the AMD Ryzen 5 5600X BOX processor and prevent it from overheating, it comes with a cooling system and a thermal interface applied to the base of the radiator.
                To maintain the stable operation of the AMD Ryzen 5 5600X BOX processor and prevent it from overheating, it comes with a cooling system and a thermal interface applied to the base of the radiator.
            </div>

            <h4>Какой-то заголовок</h4>
            <div class="mb-4">
                Для поддержания <a href="#">стабильной работы</a> процессора AMD Ryzen 5 5600X BOX и предупреждения его перегрева, в комплекте с ним предусмотрена система охлаждения и нанесенный на основание радиатора термоинтерфейс.
                Для поддержания стабильной работы процессора AMD Ryzen 5 5600X BOX и предупреждения его перегрева, в комплекте с ним предусмотрена система охлаждения и нанесенный на основание радиатора термоинтерфейс.
            </div>
            <div>
                <a href="#">Important link</a>
            </div>

        </div>
    </main>


    <footer>
        <div class="container">
            The Footer
        </div>
    </footer>
</div>

</body>
</html>
