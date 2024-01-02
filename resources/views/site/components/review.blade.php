<div class="review-cont">
    <div class="review-id-cont">#24</div>

    <div class="review-name-cont mb-2">
        <svg class="review-avatar"><use href="#userGreyAvatar"/></svg>
        <div class="review-name">Константин</div>
    </div>

    <div class="mb-3">
        <x-stars size="small" mb="1" :rating="3.5" />
        <div class="grey-text">2 месяца назад</div>
        <div>
            <span class="grey-text">{{ __('reviews.term_of_use') }}:</span> {{ __('reviews.term.days') }}
        </div>
    </div>

    <div class="review-text-block">
        <div>{{ __('reviews.pros') }}</div>
        <p>Без андервольта не особо хочется пользоваться в стрестесте 91-93. в простое 50-55. После андервольта 42-46 в простое, 84-86 в стрестесте. Так же были проблемы при первых запусках проц работал в простое 80 градусов, потом вроде перестал, будем посмотреть хз с чем связано.</p>
    </div>

    <div class="review-text-block">
        <div>{{ __('reviews.cons') }}</div>
        <p>Возможно в перспективе заменю на 3-х секционную СЖО, хотя в большинстве задач и кулера хватает</p>
    </div>

    <div class="review-text-block">
        <div>{{ __('reviews.comment') }}</div>
        <p>Заменил блок питания и подключил помпу к разъему cpu_opt (ранее была подключена к sys_fan3/pump) и больше проблем с нагревом не наблюдается. После включения 42-44 держит без нагрузки.</p>
    </div>

    <div class="review-reactions">
        <div class="review-reactions_up">
            <div class="thumb-up-icon"></div>
            <div>35</div>
        </div>
        <div class="review-reactions_down">
            <div class="thumb-down-icon"></div>
            <div>28</div>
        </div>
    </div>
</div>