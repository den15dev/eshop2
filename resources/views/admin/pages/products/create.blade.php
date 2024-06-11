@extends('admin.layout')

@section('page_title',  __('admin/products.creating_product') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/products.creating_product'))

@section('main_content')
    <div class="admin-main-page">

        <div class="admin-note mb-5">{!! __('admin/products.creating_note') !!}</div>

        <form class="mb-6" action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="productName_{{ $lang->id }}" class="form-label">{{ __('admin/products.name') . ' (' . $lang->id . ')' }}:</label>
                        <input type="text"
                               class="form-control @error('name.' . $lang->id) is-invalid @enderror"
                               name="name[{{ $lang->id }}]"
                               value="{{ old('name.' . $lang->id) }}"
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
                            <option value="{{ $brand->id }}" @selected(old('brand') == $brand->id)>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-flex-cont mb-4">
                <div>
                    <label for="productCategory" class="form-label">{{ __('admin/products.category') }}:</label>
                    <select name="category" class="form-select" id="productCategory">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                    {!! $category->has_children ? 'class="lightgrey-text" disabled' : '' !!}>
                                {{ str_repeat('-', $category->level - 1) . ' ' . $category->name }} ({{ $category->sku_num_children_all ?: $category->sku_num_all }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit">{{ __('admin/general.create') }}</button>
        </form>
    </div>
@endsection