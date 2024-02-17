<div class="filters-cont">
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

    @foreach($filter_specs as $spec)
        <x-filter.dropdown title="{{ $spec->name }}"
                           collapsed="{{ $ismobile ? 'on' : ($loop->index > 0 ? 'on' : 'off') }}"
                           :ismobile="$ismobile">
            <x-filter.specs :data="$spec" :ismobile="$ismobile" />
        </x-filter.dropdown>
    @endforeach
</div>