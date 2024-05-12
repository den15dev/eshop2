@extends('admin.layout')

@section('page_title',  __('admin/products.products') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/products.products'))

@section('main_content')
    <div>
        <div class="product-index_cont1 mb-3">
            <div class="product-index_search-category">
                <div class="product-index_search">
                    <input type="text" class="form-control" name="search" placeholder="{{ __('admin/index-page.search') }}" value="{{ $state->search }}" id="searchInput" />
                    <div class="icon-x-lg index_search_close-btn {{ $state->search ? '' : 'hidden' }}"></div>
                </div>
                <div class="product-index_category">
                    <select name="category" class="form-select">
                        <option value="" {{ $state->category_id ? '' : 'selected' }}>{{ __('admin/products.all_categories') }}</option>
                        @foreach($categories as $category)
                            @if($category->sku_num_children_all)
                                <option value="{{ $category->id }}" {{ $state->category_id === $category->id ? 'selected' : '' }}>
                                    {{ str_repeat('-', $category->level - 1) . ' ' . $category->name }} ({{ $category->sku_num_children_all }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="product-index_add-btn">
                <button>+&nbsp;&nbsp;{{ __('admin/products.add_product') }}</button>
            </div>
        </div>

        <div class="index_checkboxes mb-4">
            <div class="index_checkbox-cont">
                <input type="checkbox" class="form-check-input" name="chb[active]" id="productsActive" {{ $state->active ? 'checked' : '' }} />
                <label class="form-check-label" for="productsActive">{{ __('admin/products.in_stock') }}</label>
            </div>

            <div class="index_checkbox-cont">
                <input type="checkbox" class="form-check-input" name="chb[out_of_stock]" id="productsOutOfStock" {{ $state->out_of_stock ? 'checked' : '' }} />
                <label class="form-check-label" for="productsOutOfStock">{{ __('admin/products.out_of_stock') }}</label>
            </div>

            <div class="index_checkbox-cont">
                <input type="checkbox" class="form-check-input" name="chb[scheduled]" id="productsScheduled" {{ $state->scheduled ? 'checked' : '' }} />
                <label class="form-check-label" for="productsScheduled">{{ __('admin/products.scheduled') }}</label>
            </div>
        </div>


        <div id="indexTableCont" data-name="{{ $table_name }}">
            @include('admin.includes.index-table')
        </div>
    </div>
@endsection