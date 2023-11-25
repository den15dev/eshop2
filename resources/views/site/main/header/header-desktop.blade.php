<div class="container" id="desktopHeader">
    <div class="header-logo">
        <a href="{{ route('home') }}" class="logo logo-ru">
            <svg viewBox="0 0 20 28">
                <use href="#logoSign"/>
            </svg>
            <svg viewBox="0 0 155 26">
                <use href="#logoTitleRu"/>
            </svg>
        </a>
    </div>
    <nav class="top-center">
        <ul class="nav-list-top">
            <li>
                <a href="#">
                    Доставка
                </a>
            </li>
            <li>
                <a href="#">
                    Магазины
                </a>
            </li>
            <li>
                <a href="#">
                    Гарантия
                </a>
            </li>
            <li class="dropdown">
                <div class="dropdown-btn">
                    Покупателям
                    <span class="icon-chevron-down xsmall"></span>
                </div>
                <ul class="dropdown-list">
                    <li>
                        <a href="#">
                            Бонусная программа
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Обмен, возврат
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Сервисные центры
                        </a>
                    </li>
                </ul>
            </li>
            <li class="tel">
                <a href="tel:+78004567890">
                    <svg>
                        <use href="#telIcon"/>
                    </svg>
                    8 (800) 456-78-90
                </a>
            </li>
        </ul>
    </nav>
    <div class="top-right">
        <div class="dropdown lang-menu">
            <div class="dropdown-btn">
                <img src="{{ asset('img/flags/ru.svg') }}" alt="ru">
                Ru
                <span class="icon-chevron-down xsmall"></span>
            </div>
            <ul class="dropdown-list dd-right">
                <li>
                    <div>
                        <img src="{{ asset('img/flags/ru.svg') }}" alt="ru">
                        Русский
                        <span class="icon-check-lg me-1"></span>
                    </div>
                </li>
                <li>
                    <a href="#">
                        <img src="{{ asset('img/flags/en.svg') }}" alt="en">
                        English
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="{{ asset('img/flags/de.svg') }}" alt="de">
                        Deutsch
                    </a>
                </li>
            </ul>
        </div>
    </div>


    <div class="bottom-left">
        <button class="btn catalog-btn" id="catalogBtnDesktop">
            Каталог
            <svg class="svg-catalog-list">
                <use href="#listIcon"/>
            </svg>
            <svg class="svg-close">
                <use href="#closeIcon"/>
            </svg>
        </button>
    </div>
    <div class="bottom-center">
        <form class="search-form" method="GET" action="">
            <div class="search_results_cont" id="searchResultCont"></div>
            <input class="search-input bordered" name="query" placeholder="Поиск" autocomplete="off" id="searchInput">
            <span class="btn-icon clear-btn icon-x-lg" id="clearBtn"></span>

            <button class="btn-icon search-btn" type="submit">
                <svg>
                    <use href="#searchIcon"/>
                </svg>
            </button>
        </form>
    </div>
    <nav class="bottom-right">
        <ul class="nav-list-user">
            <li>
                <a href="#">
                    <svg viewBox="0 0 21 19">
                        <use href="#favoriteIcon"/>
                    </svg>
                    Избранное
                    <div class="badge-round">2</div>
                </a>
            </li>
            <li>
                <a href="#">
                    <svg viewBox="0 0 22 22">
                        <use href="#cartIcon"/>
                    </svg>
                    Корзина
                    <div class="badge-round-red">3</div>
                </a>
            </li>
            <li>
                <a href="#">
                    <svg viewBox="0 0 17 21">
                        <use href="#ordersIcon"/>
                    </svg>
                    Заказы
                </a>
            </li>
            <li>
                <a href="#">
                    <svg viewBox="0 0 16 20">
                        <use href="#lockIcon"/>
                    </svg>
                    Вход
                </a>
            </li>
            {{--<li>
                <a href="#">
                    <svg viewBox="0 0 18 21"><use href="#userIcon" /></svg>
                    <span style="margin-left: -2px">Регистрация</span>
                </a>
            </li>--}}
            <li class="dropdown">
                <div class="dropdown-btn">
                    <svg viewBox="0 0 18 21">
                        <use href="#userIcon"/>
                    </svg>
                    <span>Профиль</span>
                </div>
                <ul class="dropdown-list dd-right">
                    <li>
                        <a href="#">
                            <span class="icon-key me-2"></span>
                            Панель администратора
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon-gear me-2"></span>
                            Настройки
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon-bell me-2"></span>
                            Уведомления
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon-box-arrow-right me-2"></span>
                            Выход
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>