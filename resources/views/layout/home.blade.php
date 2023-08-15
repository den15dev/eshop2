<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="page-wrap">
        <header>
            <svg width="2" height="2" style="display: none">
                <symbol viewBox="0 0 155 26" id="logoTitleRu">
                    <path d="M0.909973 16.215H4.54997V19.365C4.54997 21.115 5.31997 21.745 6.54497 21.745C7.76997 21.745 8.53997 21.115 8.53997 19.365V14.08H5.00497V10.58H8.53997V6.135C8.53997 4.385 7.76997 3.72 6.54497 3.72C5.31997 3.72 4.54997 4.385 4.54997 6.135V8.445H0.979973V6.38C0.979973 2.46 2.86997 0.220001 6.64997 0.220001C10.43 0.220001 12.39 2.46 12.39 6.38V19.12C12.39 23.04 10.43 25.28 6.64997 25.28C2.86997 25.28 0.909973 23.04 0.909973 19.12V16.215Z"/>
                    <path d="M13.8159 25.035V21.535C15.5659 21.535 16.1259 21.29 16.1959 19.015L16.826 0.5H27.711V25H23.791V4H20.431L20.011 18.805C19.871 23.285 18.2609 25.035 14.4109 25.035H13.8159Z"/>
                    <path d="M34.5078 4V10.825H39.7928V14.325H34.5078V21.5H41.1578V25H30.6578V0.5H41.1578V4H34.5078Z"/>
                    <path d="M52.3285 25L48.5835 15.235L47.3935 17.475V25H43.5435V0.5H47.3935V11.175L52.4335 0.5H56.2835L50.9285 11.42L56.2835 25H52.3285Z"/>
                    <path d="M56.9157 4V0.5H68.8157V4H64.7907V25H60.9407V4H56.9157Z"/>
                    <path d="M76.1813 0.5C80.0313 0.5 81.9213 2.635 81.9213 6.555V9.74C81.9213 13.66 80.0313 15.795 76.1813 15.795H74.3613V25H70.5113V0.5H76.1813ZM76.1813 4H74.3613V12.295H76.1813C77.4063 12.295 78.0713 11.735 78.0713 9.985V6.31C78.0713 4.56 77.4063 4 76.1813 4Z"/>
                    <path d="M87.2397 6.135V19.365C87.2397 21.115 88.0097 21.78 89.2347 21.78C90.4597 21.78 91.2297 21.115 91.2297 19.365V6.135C91.2297 4.385 90.4597 3.72 89.2347 3.72C88.0097 3.72 87.2397 4.385 87.2397 6.135ZM83.3897 19.12V6.38C83.3897 2.46 85.4547 0.220001 89.2347 0.220001C93.0147 0.220001 95.0797 2.46 95.0797 6.38V19.12C95.0797 23.04 93.0147 25.28 89.2347 25.28C85.4547 25.28 83.3897 23.04 83.3897 19.12Z"/>
                    <path d="M101.432 14.5V25H97.5816V0.5H101.432V11H105.807V0.5H109.727V25H105.807V14.5H101.432Z"/>
                    <path d="M119.693 13.765L116.473 25H112.518V0.5H115.948V16.005L117.348 10.615L120.498 0.5H124.733V25H121.268V7.745L119.693 13.765Z"/>
                    <path d="M136.24 25L132.495 15.235L131.305 17.475V25H127.455V0.5H131.305V11.175L136.345 0.5H140.195L134.84 11.42L140.195 25H136.24Z"/>
                    <path d="M150.487 0.5L154.407 25H150.522L149.857 20.555H145.132L144.467 25H140.932L144.852 0.5H150.487ZM147.477 4.84L145.622 17.23H149.332L147.477 4.84Z"/>
                </symbol>

                <symbol viewBox="0 0 138 26" id="logoTitleEn">
                    <path d="M4.25002 4V10.825H9.53502V14.325H4.25002V21.5H10.9V25H0.400024V0.5H10.9V4H4.25002Z"/>
                    <path d="M13.2858 25V0.5H17.1358V21.5H23.4708V25H13.2858Z"/>
                    <path d="M28.9961 4V10.825H34.2811V14.325H28.9961V21.5H35.6461V25H25.1461V0.5H35.6461V4H28.9961Z"/>
                    <path d="M45.5569 15.865H49.1969V19.12C49.1969 23.04 47.2369 25.28 43.4569 25.28C39.6769 25.28 37.7169 23.04 37.7169 19.12V6.38C37.7169 2.46 39.6769 0.220001 43.4569 0.220001C47.2369 0.220001 49.1969 2.46 49.1969 6.38V8.76H45.5569V6.135C45.5569 4.385 44.7869 3.72 43.5619 3.72C42.3369 3.72 41.5669 4.385 41.5669 6.135V19.365C41.5669 21.115 42.3369 21.745 43.5619 21.745C44.7869 21.745 45.5569 21.115 45.5569 19.365V15.865Z"/>
                    <path d="M50.4128 4V0.5H62.3128V4H58.2878V25H54.4378V4H50.4128Z"/>
                    <path d="M75.9784 25H72.0584C71.8484 24.37 71.7084 23.985 71.7084 21.99V18.14C71.7084 15.865 70.9384 15.025 69.1884 15.025H67.8584V25H64.0084V0.5H69.8184C73.8084 0.5 75.5234 2.355 75.5234 6.135V8.06C75.5234 10.58 74.7184 12.225 73.0034 13.03C74.9284 13.835 75.5584 15.69 75.5584 18.245V22.025C75.5584 23.215 75.5934 24.09 75.9784 25ZM69.7134 4H67.8584V11.525H69.3634C70.7984 11.525 71.6734 10.895 71.6734 8.935V6.52C71.6734 4.77 71.0784 4 69.7134 4Z"/>
                    <path d="M81.6255 6.135V19.365C81.6255 21.115 82.3955 21.78 83.6205 21.78C84.8455 21.78 85.6155 21.115 85.6155 19.365V6.135C85.6155 4.385 84.8455 3.72 83.6205 3.72C82.3955 3.72 81.6255 4.385 81.6255 6.135ZM77.7755 19.12V6.38C77.7755 2.46 79.8405 0.220001 83.6205 0.220001C87.4005 0.220001 89.4655 2.46 89.4655 6.38V19.12C89.4655 23.04 87.4005 25.28 83.6205 25.28C79.8405 25.28 77.7755 23.04 77.7755 19.12Z"/>
                    <path d="M100.192 25L95.3974 7.255V25H91.9324V0.5H96.7624L100.717 15.165V0.5H104.147V25H100.192Z"/>
                    <path d="M106.904 25V0.5H110.754V25H106.904Z"/>
                    <path d="M121.094 15.865H124.734V19.12C124.734 23.04 122.774 25.28 118.994 25.28C115.214 25.28 113.254 23.04 113.254 19.12V6.38C113.254 2.46 115.214 0.220001 118.994 0.220001C122.774 0.220001 124.734 2.46 124.734 6.38V8.76H121.094V6.135C121.094 4.385 120.324 3.72 119.099 3.72C117.874 3.72 117.104 4.385 117.104 6.135V19.365C117.104 21.115 117.874 21.745 119.099 21.745C120.324 21.745 121.094 21.115 121.094 19.365V15.865Z"/>
                    <path d="M126.58 6.38C126.58 2.46 128.505 0.220001 132.25 0.220001C135.995 0.220001 137.92 2.46 137.92 6.38V7.15H134.28V6.135C134.28 4.385 133.58 3.72 132.355 3.72C131.13 3.72 130.43 4.385 130.43 6.135C130.43 11.175 137.955 12.12 137.955 19.12C137.955 23.04 135.995 25.28 132.215 25.28C128.435 25.28 126.475 23.04 126.475 19.12V17.615H130.115V19.365C130.115 21.115 130.885 21.745 132.11 21.745C133.335 21.745 134.105 21.115 134.105 19.365C134.105 14.325 126.58 13.38 126.58 6.38Z"/>
                </symbol>

                <symbol viewBox="0 0 20 28" id="logoSign">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4333 0.700012V3.55716H14.6934C15.8479 3.55716 16.6334 4.53217 16.6334 5.54287V6.41428H19.3V9.01428H16.6334V12.7H19.3V15.3H16.6334V18.9857H19.3V21.5857H16.6334V22.4572C16.6334 23.4679 15.8479 24.4429 14.6934 24.4429H13.4333V27.3H10.8333V24.4429H9.16671V27.3H6.56671V24.4429H5.3067C4.15229 24.4429 3.3667 23.468 3.3667 22.4572V21.5857H0.700012V18.9857H3.3667V15.3H0.700012V12.7H3.3667V9.01428H0.700012V6.41428H3.3667V5.54287C3.3667 4.53213 4.15225 3.55716 5.3067 3.55716H6.56671V0.700012H9.16671V3.55716H10.8333V0.700012H13.4333ZM14.0334 18.9857H14.0333V21.5857H14.0334V21.8429L13.4333 21.8429H10.8333H9.16671H6.56671L5.9667 21.8429V6.15716H14.0334V6.41428H14.0333V9.01428H14.0334V12.7H14.0333V15.3H14.0334V18.9857Z"/>
                </symbol>

                <symbol viewBox="0 0 15 14" id="catalogList">
                    <path d="M1.40381 1.71429H13.5961" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M1.40381 7H13.5961" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M1.40381 12.2857H13.5961" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </symbol>

                <symbol viewBox="0 0 20 12" id="catalogChevronDown">
                    <path d="M2 2L10 10L18 2" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </symbol>

                <symbol viewBox="0 0 29 29" id="searchIcon">
                    <path d="M20.75 20.75L27 27" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 12.7143C2 18.6316 6.79695 23.4286 12.7143 23.4286C15.678 23.4286 18.3609 22.2252 20.3005 20.2804C22.2336 18.3423 23.4286 15.6679 23.4286 12.7143C23.4286 6.79695 18.6316 2 12.7143 2C6.79695 2 2 6.79695 2 12.7143Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </symbol>

                <symbol viewBox="0 0 23 23" id="closeIcon">
                    <path d="M1.79999 21L11.4 11.4001M11.4 11.4001L21 1.80002M11.4 11.4001L1.79999 1.80002M11.4 11.4001L21 21" stroke-linecap="round" stroke-linejoin="round"/>
                </symbol>
            </svg>


            <div class="container" id="desktopHeader">
                <div class="header-logo">
                    <a href="{{ route('home') }}" class="logo logo-ru">
                        <svg viewBox="0 0 20 28"><use href="#logoSign" /></svg>
                        <svg viewBox="0 0 155 26"><use href="#logoTitleRu" /></svg>
                    </a>
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
                    <button class="btn catalog-btn" id="catalogBtnDesktop">
                        Каталог
                        <svg class="svg-catalog-list"><use href="#catalogList" /></svg>
                        <svg class="svg-close"><use href="#closeIcon" /></svg>
                    </button>
                </div>
                <div class="bottom-center">
                    <form class="search-form" method="GET" action="">
                        <div class="search_results_cont" id="search_result_cont"></div>
                        <input class="search_input bordered" name="query" placeholder="Поиск" autocomplete="off" id="search_input">
                        <span class="btn-icon clear_btn icon-x-lg" id="clear_btn"></span>
                        <button class="btn-icon search_btn" type="submit">
                            <svg><use href="#searchIcon" /></svg>
                        </button>
                    </form>
                </div>
                <div class="bottom-right">User menu icons go here</div>
            </div>


            <div class="container" id="mobileHeader">
                <button class="btn catalog-btn-mobile" id="catalogBtnMobile">
                    <svg class="svg-chevron-down"><use href="#catalogChevronDown" /></svg>
                    <svg class="svg-close"><use href="#closeIcon" /></svg>
                </button>
                <div class="header-logo-mobile">
                    <a href="{{ route('home') }}" class="logo logo-ru">
                        <svg viewBox="0 0 20 28"><use href="#logoSign" /></svg>
                        <svg viewBox="0 0 155 26"><use href="#logoTitleRu" /></svg>
                    </a>
                </div>
                <button class="btn-icon search-btn-mobile">
                    <svg><use href="#searchIcon" /></svg>
                </button>
            </div>


            <div class="catalog-nav-cont" id="catalogNavCont">
                <div class="container" id="catalogNavDesktop">
                    <ul>
                        <li>Компьютерные комплектующие</li>
                        <li>Бытовая техника</li>
                        <li>Телевизоры и аксессуары</li>
                    </ul>
                </div>

                <div class="container" id="catalogNavMobile">
                    <ul>
                        <li>М - Компьютерные комплектующие</li>
                        <li>М - Бытовая техника</li>
                        <li>М - Телевизоры и аксессуары</li>
                    </ul>
                </div>
            </div>

            <div class="catalog-nav-tint"></div>

        </header>


        <div class="shadow-toggler"></div>

        <script>
            const header = document.querySelector('header');
            const shadowToggler = document.querySelector('.shadow-toggler');
            const observer = new IntersectionObserver(([entry]) => {
                header.classList.toggle('header-shadow', !entry.isIntersecting);
            });

            observer.observe(shadowToggler);
        </script>



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

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                            <div id="exampleFormControlInput1" class="form-text">
                                Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                            </div>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked1" checked>
                            <label class="form-check-label" for="flexSwitchCheckChecked1">Checked switch checkbox input</label>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                            <div id="exampleFormControlInput1" class="form-text">
                                Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                            </div>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked2" checked>
                            <label class="form-check-label" for="flexSwitchCheckChecked2">Checked switch checkbox input</label>
                        </div>
                    </div>
                </div>

                <button class="btn mb-4">Каталог</button>



                <h4>Какой-то заголовок</h4>
                <div class="mb-4">
                    Для поддержания <a href="#" class="link">стабильной работы</a> процессора AMD Ryzen 5 5600X BOX и предупреждения его перегрева, в комплекте с ним предусмотрена система охлаждения и нанесенный на основание радиатора термоинтерфейс.
                    Для поддержания стабильной работы процессора AMD Ryzen 5 5600X BOX и предупреждения его перегрева, в комплекте с ним предусмотрена система охлаждения и нанесенный на основание радиатора термоинтерфейс.
                </div>

                <div class="row mb-4">
                    <div class="col-6 col-lg-2">
                        <a href="#" class="link">Important link</a><br>
                        <a href="#" class="dark-link">Darkish link</a>
                    </div>

                    <div class="col-6 col-lg-2">
                        <span class="fw-light">Текст Light</span><br>
                        <span>Обычный текст</span><br>
                        <span class="fw-semibold">Текст Semibold</span><br>
                        <span class="fw-bold">Текст Bold</span><br>
                    </div>
                </div>

                <h3>Заголовок чуть больше</h3>
                <div class="mb-4">
                    В старинном лечебнике XVII века «Прохладный вертоград» указано, что растение использовали в медицине того времени как противовоспалительное, ранозаживляющее и мочегонное средство, для укрепления дёсен, сохранения зрения, при потере аппетита и расстройстве пищеварения, при мочекаменной болезни, а также при болезнях печени и почек и др. В XIX веке из семян был получен препарат, применявшийся при дисменорее, невралгии и малярии.
                    Различные блюда с использованием петрушки имеют мочегонное действие, способствуют выведению солей из организма. Зелень петрушки уменьшает потливость, показана при заболеваниях почек и печени, атеросклерозе. Некоторые зарубежные учёные считают, что свежий сок петрушки способствует нормализации функций коры надпочечников и щитовидной железы, укреплению капиллярных кровеносных сосудов и др.
                    В клинических испытаниях было показано, что при употреблении препаратов петрушки повышается тонус гладкой мускулатуры матки, кишечника, мочевого пузыря. Свежие листья петрушки или их отвар в экспериментальных исследованиях увеличивали жёлчеотделение. Отвар петрушки был предложен для лечения гипотонических и гипокинетических дискинезий жёлчного пузыря. Различные препараты петрушки используют при цистите, мочекаменной болезни, отёках, почечных спазмах (противопоказаны при нефрите), при воспалении предстательной железы.
                    Петрушка богата мирицетином (14,84 мг/100 г), который обладает широким спектром полезных свойств для здоровья, включая сильное противоопухолевое действие.
                </div>

                <h3>Заголовок чуть больше</h3>
                <div class="mb-4">
                    В старинном лечебнике XVII века «Прохладный вертоград» указано, что растение использовали в медицине того времени как противовоспалительное, ранозаживляющее и мочегонное средство, для укрепления дёсен, сохранения зрения, при потере аппетита и расстройстве пищеварения, при мочекаменной болезни, а также при болезнях печени и почек и др. В XIX веке из семян был получен препарат, применявшийся при дисменорее, невралгии и малярии.
                    Различные блюда с использованием петрушки имеют мочегонное действие, способствуют выведению солей из организма. Зелень петрушки уменьшает потливость, показана при заболеваниях почек и печени, атеросклерозе. Некоторые зарубежные учёные считают, что свежий сок петрушки способствует нормализации функций коры надпочечников и щитовидной железы, укреплению капиллярных кровеносных сосудов и др.
                    В клинических испытаниях было показано, что при употреблении препаратов петрушки повышается тонус гладкой мускулатуры матки, кишечника, мочевого пузыря. Свежие листья петрушки или их отвар в экспериментальных исследованиях увеличивали жёлчеотделение. Отвар петрушки был предложен для лечения гипотонических и гипокинетических дискинезий жёлчного пузыря. Различные препараты петрушки используют при цистите, мочекаменной болезни, отёках, почечных спазмах (противопоказаны при нефрите), при воспалении предстательной железы.
                    Петрушка богата мирицетином (14,84 мг/100 г), который обладает широким спектром полезных свойств для здоровья, включая сильное противоопухолевое действие.
                </div>

                <h3>Заголовок чуть больше</h3>
                <div class="mb-4">
                    В старинном лечебнике XVII века «Прохладный вертоград» указано, что растение использовали в медицине того времени как противовоспалительное, ранозаживляющее и мочегонное средство, для укрепления дёсен, сохранения зрения, при потере аппетита и расстройстве пищеварения, при мочекаменной болезни, а также при болезнях печени и почек и др. В XIX веке из семян был получен препарат, применявшийся при дисменорее, невралгии и малярии.
                    Различные блюда с использованием петрушки имеют мочегонное действие, способствуют выведению солей из организма. Зелень петрушки уменьшает потливость, показана при заболеваниях почек и печени, атеросклерозе. Некоторые зарубежные учёные считают, что свежий сок петрушки способствует нормализации функций коры надпочечников и щитовидной железы, укреплению капиллярных кровеносных сосудов и др.
                    В клинических испытаниях было показано, что при употреблении препаратов петрушки повышается тонус гладкой мускулатуры матки, кишечника, мочевого пузыря. Свежие листья петрушки или их отвар в экспериментальных исследованиях увеличивали жёлчеотделение. Отвар петрушки был предложен для лечения гипотонических и гипокинетических дискинезий жёлчного пузыря. Различные препараты петрушки используют при цистите, мочекаменной болезни, отёках, почечных спазмах (противопоказаны при нефрите), при воспалении предстательной железы.
                    Петрушка богата мирицетином (14,84 мг/100 г), который обладает широким спектром полезных свойств для здоровья, включая сильное противоопухолевое действие.
                </div>

            </div>
        </main>


        <footer>
            <div class="container">
                The Footer
            </div>
        </footer>
    </div>


    <script src="{{ asset('js/vendors/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
</body>
</html>
