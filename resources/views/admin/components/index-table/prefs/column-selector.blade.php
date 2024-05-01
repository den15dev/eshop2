<div class="column-selector dropdown" data-cookie-name="{{ $cookie }}">
    <div class="dropdown-btn">
        {{ __('admin/index-page.columns') }}
        <span class="icon-chevron-down xsmall"></span>
    </div>
    <div class="dropdown-list column-selector_win">
        <div class="column-selector_list-cont mb-25">
            @foreach($list as $item)
                <div class="column-selector_item">
                    <input type="checkbox"
                           class="form-check-input"
                           name="columns[{{ $item->index }}]"
                           id="{{ $item->input_id }}"
                           data-index="{{ $item->index }}"
                           {{ $item->is_checked ? 'checked' : '' }} />
                    <label class="form-check-label" for="{{ $item->input_id }}">{{ $item->name }}</label>
                </div>
            @endforeach
        </div>

        <div class="icon-x-lg column-selector_close-btn"></div>

        <button class="column-selector_apply-btn">{{ __('admin/index-page.apply') }}</button>
    </div>
</div>