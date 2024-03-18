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

    @php
        $is_any_checked = false;
        foreach ($filter_specs as $spec) {
            if ($spec->has_checked) {
                $is_any_checked = true;
                break;
            }
        }
    @endphp

    @foreach($filter_specs as $spec)
        @php
            $collapsed = 'on';
            if ($spec->has_checked) $collapsed = 'off';
            if (!$is_any_checked && !$ismobile && !$loop->index) $collapsed = 'off';
        @endphp

        <x-filter.dropdown title="{{ $spec->name }}"
                           :collapsed="$collapsed"
                           :ismobile="$ismobile">
            <x-filter.specs :data="$spec" :ismobile="$ismobile" />
        </x-filter.dropdown>
    @endforeach
</div>