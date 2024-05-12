<div class="product-edit_{{ $type }}-item"
     data-type="{{ $type }}"
     {!! isset($attribute) ? 'data-attribute="' . $attribute->id . '"' : '' !!}
     {!! isset($product) ? 'data-product="' . $product->id . '"' : '' !!}>
    <div class="dropdown-btn product-edit_add-item_dd-btn">
        + {{ __('admin/products.add_' . $type) }}
    </div>
    
    <div class="dropdown-list product-edit_attribute-dd-win">
        <div class="mb-25">
            @foreach($languages as $lang)
                <div class="product-edit_attribute_input-cont" data-lang="{{ $lang->id }}">
                    @php
                        $id = isset($attribute) ? 'attr_' . $attribute->id . '_new_variant' : 'new_attribute';
                        $id .=  '_' . $lang->id;
                    @endphp
                    <label for="{{ $id }}" class="form-label">{{ $lang->id }}:</label>
                    <div>
                        <input type="text"
                               class="form-control"
                               name="name[{{ $lang->id }}]"
                               value=""
                               id="{{ $id }}" />
                        <div id="{{ $id }}Feedback" class="invalid-feedback"></div>
                    </div>
                </div>
            @endforeach
        </div>
    
        <div class="product-edit_attribute_btns">
            <div class="product-edit_attribute_add-btn">{{ __('admin/general.add') }}</div>
            <div class="product-edit_attribute_close-btn">{{ __('admin/general.close') }}</div>
        </div>
    </div>
</div>