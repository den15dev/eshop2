@extends('admin.layout')

@section('page_title',  __('admin/products.editing_product') . ' ' . $product->id . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/products.editing_product'))

@section('main_content')
    <div class="admin-main-page">
        <div class="mb-3">
            <span class="grey-text">ID {{ $product->id }}:</span> {{ $product->name }}
        </div>

        <form class="mb-6" action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="productName_{{ $lang->id }}" class="form-label">{{ __('admin/products.name') . ' (' . $lang->id . ')' }}:</label>
                        <input type="text"
                               class="form-control @error('name.' . $lang->id) is-invalid @enderror"
                               name="name[{{ $lang->id }}]"
                               value="{{ old('name.' . $lang->id, $product->getTranslation('name', $lang->id)) }}"
                               id="productName_{{ $lang->id }}" />
                        @error('name.' . $lang->id)
                        <div id="productName_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="form-flex-cont mb-4">
                <div>
                    <label for="productBrand" class="form-label">{{ __('admin/products.brand') }}:</label>
                    <select name="brand" class="form-select" id="productBrand">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $brand->id === $product->brand_id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit">{{ __('admin/general.save') }}</button>
        </form>


        <h5 class="mb-3">{{ __('admin/products.category') }}</h5>

        <form class="mb-6" action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="fst-italic mb-3">
                <span class="fw-semibold">{{ __('admin/general.caution') }}</span> {{ __('admin/products.category_note') }}
            </div>

            <div class="form-flex-cont mb-4">
                <div>
                    <select name="category" class="form-select" id="productCategory">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                    {!! $category->level < 3 ? 'class="lightgrey-text"' : '' !!}
                                    {{ $category->id === $product->category_id ? 'selected' : '' }}
                                    {{  $category->level < 3 ? 'disabled' : '' }}>
                                {{ str_repeat('-', $category->level - 1) . ' ' . $category->name }} ({{ $category->sku_num_children_all }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" id="changeCategoryBtn">{{ __('admin/general.move') }}</button>
        </form>


        <h5 class="mb-3">SKU</h5>

        <ul class="mb-4">
            @foreach($skus as $sku)
                <li class="mb-1">
                    <a href="{{ route('admin.skus.edit', $sku->id) }}" class="link">
                        {{ $sku->id }}. {{ $sku->name }}
                    </a>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('admin.skus.create') }}" class="btn btn-add mb-6">+&nbsp;&nbsp;{{ __('admin/products.add_sku') }}</a>


        <h5 class="mb-3">{{ __('admin/products.attributes') }}</h5>

        <div class="mb-6">
            @if($product->attributes->count())
                <ul class="product-edit_attribute-list">
                    @foreach($product->attributes as $attribute)
                        <li class="mb-3">
                            <x-admin::attribute-edit-dropdown type="attribute" :languages="$languages" :item="$attribute" />

                            <div class="product-edit_variant-list">
                                @foreach($attribute->variants as $variant)
                                    <x-admin::attribute-edit-dropdown type="variant" :languages="$languages" :item="$variant" />
                                @endforeach
                                <x-admin::attribute-add-dropdown type="variant" :languages="$languages" :attribute="$attribute" />
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
            <x-admin::attribute-add-dropdown type="attribute" :languages="$languages" :product="$product" />
        </div>


        <form class="mb-4" action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <button class="btn-bg-red">{{ __('admin/products.delete_product') }}</button>
        </form>
    </div>
@endsection