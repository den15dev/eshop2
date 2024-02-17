<div class="filters-cont">
    <x-filter.dropdown title="{{ __('filters.titles.category') }}"
                       collapsed="off"
                       :ismobile="$ismobile">
        <x-filter.list name="categories" :data="$filter_categories" :ismobile="$ismobile" />
    </x-filter.dropdown>

    <x-filter.dropdown title="{{ __('filters.titles.price') }}"
                       collapsed="off"
                       :ismobile="$ismobile">
        <x-filter.price :range="$price_range" />
    </x-filter.dropdown>

    <x-filter.dropdown title="{{ __('filters.titles.brand') }}"
                       collapsed="off"
                       :ismobile="$ismobile">
        <x-filter.list name="brands" :data="$filter_brands" :ismobile="$ismobile" />
    </x-filter.dropdown>
</div>