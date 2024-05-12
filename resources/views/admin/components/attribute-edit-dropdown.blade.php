<div class="product-edit_{{ $type }}-item" data-type="{{ $type }}" data-id="{{ $item->id }}">
    <div class="dropdown-btn product-edit_{{ $type }}-item_dd-btn">
        @php
            $item_names = [];
            foreach ($languages as $lang) {
                $item_names[] = $item->getTranslation('name', $lang->id, false) ?: '---';
            }
            $item_names_str = implode(' / ', $item_names);
        @endphp
        {{ $item_names_str }}
    </div>
    
    <div class="dropdown-list product-edit_attribute-dd-win">
        <div class="mb-25">
            @foreach($languages as $lang)
                <div class="product-edit_attribute_input-cont" data-lang="{{ $lang->id }}">
                    @php
                        $id = $type . '_' . $item->id . '_' . $lang->id;
                    @endphp
                    <label for="{{ $id }}" class="form-label">{{ $lang->id }}:</label>
                    <div>
                        <input type="text"
                               class="form-control"
                               name="name[{{ $lang->id }}]"
                               value="{{ $item->getTranslation('name', $lang->id, false) }}"
                               id="{{ $id }}" />
                        <div id="{{ $id }}Feedback" class="invalid-feedback"></div>
                    </div>
                </div>
            @endforeach
        </div>
    
        <div class="product-edit_attribute_btns">
            <div class="product-edit_attribute_save-btn">{{ __('admin/general.save') }}</div>
            <div class="product-edit_attribute_delete-btn">{{ __('admin/general.delete') }}</div>
            <div class="product-edit_attribute_close-btn">{{ __('admin/general.close') }}</div>
        </div>
    </div>
</div>