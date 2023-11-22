@extends('layout')

@section('main_content')
    <div class="container">

        <div class="promo-banner mb-4">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="#">
                            <picture>
                                <source srcset="{{ asset('storage/images/promos/1/akcia_na_videokarty_nvidia.jpg') }}" media="(min-width: 1140px)" />
                                <source srcset="{{ asset('storage/images/promos/1/akcia_na_videokarty_nvidia_1140.jpg') }}" media="(min-width: 992px)" />
                                <source srcset="{{ asset('storage/images/promos/1/akcia_na_videokarty_nvidia_992.jpg') }}" media="(min-width: 768px)" />
                                <img src="{{ asset('storage/images/promos/1/akcia_na_videokarty_nvidia_788.jpg') }}" alt="" />
                            </picture>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#">
                            <picture>
                                <source srcset="{{ asset('storage/images/promos/2/amd_cpu_promo_001.jpg') }}" media="(min-width: 1140px)" />
                                <source srcset="{{ asset('storage/images/promos/2/amd_cpu_promo_001_1140.jpg') }}" media="(min-width: 992px)" />
                                <source srcset="{{ asset('storage/images/promos/2/amd_cpu_promo_001_992.jpg') }}" media="(min-width: 768px)" />
                                <img src="{{ asset('storage/images/promos/2/amd_cpu_promo_001_788.jpg') }}" alt="" />
                            </picture>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#">
                            <picture>
                                <source srcset="{{ asset('storage/images/promos/3/intel_13gen_promo_001.jpg') }}" media="(min-width: 1140px)" />
                                <source srcset="{{ asset('storage/images/promos/3/intel_13gen_promo_001_1140.jpg') }}" media="(min-width: 992px)" />
                                <source srcset="{{ asset('storage/images/promos/3/intel_13gen_promo_001_992.jpg') }}" media="(min-width: 768px)" />
                                <img src="{{ asset('storage/images/promos/3/intel_13gen_promo_001_788.jpg') }}" alt="" />
                            </picture>
                        </a>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="swiper-pagination-outside"></div>
        </div>


        <p>Version 2.0.1.18<br>The app plugged to Docker.</p>


        <h1>Very big title</h1>
        <div class="mb-4">
            To maintain the stable operation of the AMD Ryzen 5 5600X BOX processor and prevent it from overheating, it comes with a cooling system and a thermal interface applied to the base of the radiator.
            To maintain the stable operation of the AMD Ryzen 5 5600X BOX processor and prevent it from overheating, it comes with a cooling system and a thermal interface applied to the base of the radiator.
        </div>


        {{--<ul class="small mb-4">
        @foreach($out as $row)
            <li>{{ $row->id . ': ' . $row->spec_value }}</li>
        @endforeach
        </ul>--}}


        <h2>Ещё по-больше</h2>
        <div class="mb-4">
            Для поддержания стабильной работы процессора AMD Ryzen 5 5600X BOX и предупреждения его перегрева, в комплекте с ним предусмотрена система охлаждения и нанесенный на основание радиатора термоинтерфейс.
            Для поддержания стабильной работы процессора AMD Ryzen 5 5600X BOX и предупреждения его перегрева, в комплекте с ним предусмотрена система охлаждения и нанесенный на основание радиатора термоинтерфейс.
        </div>


        <h2>Лучшие цены</h2>

        <div class="swiper product-carousel mb-6">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><x-product-card num="1" /></div>
                <div class="swiper-slide"><x-product-card num="2" /></div>
                <div class="swiper-slide"><x-product-card num="3" /></div>
                <div class="swiper-slide"><x-product-card num="4" /></div>
                <div class="swiper-slide"><x-product-card num="5" /></div>
                <div class="swiper-slide"><x-product-card num="6" /></div>
                <div class="swiper-slide"><x-product-card num="7" /></div>
                <div class="swiper-slide"><x-product-card num="8" /></div>
                <div class="swiper-slide"><x-product-card num="9" /></div>
            </div>
            <div class="carousel-next-btn">
                <span class="icon-chevron-right"></span>
            </div>
            <div class="carousel-prev-btn">
                <span class="icon-chevron-left"></span>
            </div>
        </div>


        <h2>Новинки</h2>

        <div class="swiper product-carousel mb-6">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><x-product-card num="1" /></div>
                <div class="swiper-slide"><x-product-card num="2" /></div>
                <div class="swiper-slide"><x-product-card num="3" /></div>
                <div class="swiper-slide"><x-product-card num="4" /></div>
                <div class="swiper-slide"><x-product-card num="5" /></div>
                <div class="swiper-slide"><x-product-card num="6" /></div>
                <div class="swiper-slide"><x-product-card num="7" /></div>
                <div class="swiper-slide"><x-product-card num="8" /></div>
                <div class="swiper-slide"><x-product-card num="9" /></div>
            </div>
            <div class="carousel-next-btn">
                <span class="icon-chevron-right"></span>
            </div>
            <div class="carousel-prev-btn">
                <span class="icon-chevron-left"></span>
            </div>
        </div>


        <h2>Популярные</h2>

        <div class="swiper product-carousel mb-5">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><x-product-card num="1" /></div>
                <div class="swiper-slide"><x-product-card num="2" /></div>
            </div>
            <div class="carousel-next-btn">
                <span class="icon-chevron-right"></span>
            </div>
            <div class="carousel-prev-btn">
                <span class="icon-chevron-left"></span>
            </div>
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
                    <label for="exampleFormControlInput2" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleFormControlInput2" placeholder="name@example.com">
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
@endsection