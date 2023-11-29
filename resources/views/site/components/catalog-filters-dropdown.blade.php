<div class="filters-dropdown" data-collapsed="{{ $collapsed }}">
    <div class="filters-header">
        <svg class="filters-chevron">
            <use href="#sidebarChevron"/>
        </svg>
        <div class="filters-title">{{ $title }}</div>
    </div>
    <div class="{{ $ismobile ? 'filters-section' : 'filters-section-scroll scrollbar-thin' }}">
        @php
            $id_prefix = $ismobile ? 'bnav_' : '';
        @endphp
        @if($type === 'price')
            <div class="px-3">
                <div class="mt-1 mb-2">
                    От <input type="text" class="form-control form-control-sm mx-1 filters-price-input" name="price_min" value="" placeholder="{{ $data[0] }}"/> руб
                </div>
                <div class="mb-1">
                    до <input type="text" class="form-control form-control-sm mx-1 filters-price-input" name="price_max" value="" placeholder="{{ $data[1] }}"/> руб
                </div>
            </div>

        @elseif($type === 'brands')
            <ul class="filters_spec-list">
                @foreach($data as $brand)
                    @php
                        $elem_id = $id_prefix . 'brand' . $brand->id;
                        $disabled = $loop->count == 1;
                    @endphp
                    <li @disabled($disabled)>
                        <input class="form-check-input"
                               type="checkbox"
                               name="brands[{{ $brand->id }}]"
                               value="{{ $brand->name }}"
                               id="{{ $elem_id }}"
                                @disabled($disabled)>
                        <label class="form-check-label" for="{{ $elem_id }}">
                            {{ $brand->name }} <span class="lightgrey-text"> ({{ $brand->product_num }})</span>
                        </label>
                    </li>
                @endforeach
            </ul>

        @elseif($type === 'specs')
            <ul class="filters_spec-list">
                @foreach($data->values as $name => $qty)
                    @php
                        $elem_id = $id_prefix . $type . $data->id . '_' . $loop->index;
                        $disabled = $loop->count == 1;
                    @endphp
                    <li @disabled($disabled)>
                        <input class="form-check-input"
                               type="checkbox"
                               name="{{ $type }}[{{ $data->id }}][{{ $loop->index }}]"
                               value="{{ $name }}"
                               id="{{ $elem_id }}"
                                @disabled($disabled)>
                        <label class="form-check-label" for="{{ $elem_id }}">
                            {{ $name }} <span class="lightgrey-text"> ({{ $qty }})</span>
                        </label>
                    </li>
                @endforeach
            </ul>

        @endif
    </div>
</div>