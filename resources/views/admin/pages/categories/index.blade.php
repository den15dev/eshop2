@extends('admin.layout')

@section('page_title',  __('admin/categories.categories') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/categories.categories'))

@section('main_content')
    <div class="admin-main-page">
        @include('site.main.header.catalog-icons')

        <svg width="2" height="2" style="display: none">
            <symbol viewBox="0 0 24 24" id="categoriesEditIcon">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                <path d="M16 5l3 3" />
            </symbol>

            <symbol viewBox="0 0 24 24" id="categoriesAddIcon">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 6V18"/>
                <path d="M6 12H18"/>
            </symbol>

            <symbol viewBox="0 0 24 24" id="categoriesChevronIcon">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M9 6l6 6l-6 6" />
            </symbol>
        </svg>

        <ul class="category-tree">
            @foreach($categories as $cat_level1)
                <li>
                    <div class="category-tree_level1-item">
                        <svg viewBox="0 0 24 24" class="category-tree_level1-icon">
                            <use href="#catalogIcon_{{ $cat_level1['slug'] }}"/>
                        </svg>
                        <div class="category-tree_item-text">
                            <span class="category-tree_item-name level1">{{ $cat_level1['name'] }}</span>
                            <span class="category-tree_products-num">{{ $cat_level1['product_count_all'] ?: '' }}</span>
                        </div>
                        <div class="category-tree_control-btns">
                            <a href="{{ route('admin.categories.edit', $cat_level1['id']) }}" class="category-tree_control-btn" title="{{ __('admin/categories.edit_category') }}">
                                <svg viewBox="0 0 24 24">
                                    <use href="#categoriesEditIcon"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.categories.create', ['parent_id' => $cat_level1['id']]) }}" class="category-tree_control-btn" title="{{ __('admin/categories.add_child') }}">
                                <svg viewBox="0 0 24 24">
                                    <use href="#categoriesAddIcon"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    @isset($cat_level1['subcategories'])
                        <ul>
                            @foreach($cat_level1['subcategories'] as $cat_level2)
                                <li>
                                    <div class="category-tree_inner-item level{{ $cat_level2['level'] }}">
                                        @isset($cat_level2['subcategories'])
                                            <svg viewBox="0 0 24 24" class="category-tree_chevron-icon">
                                                <use href="#categoriesChevronIcon"/>
                                            </svg>
                                        @else
                                            <div class="category-tree_chevron-empty"></div>
                                        @endisset
                                        <div class="category-tree_item-text">
                                            <span class="category-tree_item-name level{{ $cat_level2['level'] }}">{{ $cat_level2['name'] }}</span>
                                            <span class="category-tree_products-num">{{ $cat_level2['product_count_all'] ?: '' }}</span>
                                        </div>
                                        <div class="category-tree_control-btns">
                                            <a href="{{ route('admin.categories.edit', $cat_level2['id']) }}" class="category-tree_control-btn" title="{{ __('admin/categories.edit_category') }}">
                                                <svg viewBox="0 0 24 24">
                                                    <use href="#categoriesEditIcon"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.categories.create', ['parent_id' => $cat_level2['id']]) }}" class="category-tree_control-btn" title="{{ __('admin/categories.add_child') }}">
                                                <svg viewBox="0 0 24 24">
                                                    <use href="#categoriesAddIcon"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>

                                    @isset($cat_level2['subcategories'])
                                        <ul>
                                            @foreach($cat_level2['subcategories'] as $cat_level3)
                                                <li>
                                                    <div class="category-tree_inner-item level{{ $cat_level3['level'] }}">
                                                        @isset($cat_level3['subcategories'])
                                                            <svg viewBox="0 0 24 24" class="category-tree_chevron-icon">
                                                                <use href="#categoriesChevronIcon"/>
                                                            </svg>
                                                            <div class="category-tree_item-text">
                                                                <span class="category-tree_item-name level{{ $cat_level3['level'] }}">{{ $cat_level3['name'] }}</span>
                                                                <span class="category-tree_products-num">{{ $cat_level3['product_count_all'] ?: '' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="category-tree_chevron-empty"></div>
                                                            <a href="{{ route('admin.categories.edit', $cat_level3['id']) }}" class="category-tree_item-text" title="{{ __('admin/categories.edit_category') }}">
                                                                <span class="category-tree_item-name level{{ $cat_level3['level'] }}">{{ $cat_level3['name'] }}</span>
                                                                <span class="category-tree_products-num">{{ $cat_level3['product_count_all'] ?: '' }}</span>
                                                            </a>
                                                        @endisset
                                                        <div class="category-tree_control-btns">
                                                            @isset($cat_level3['subcategories'])
                                                                <a href="{{ route('admin.categories.edit', $cat_level3['id']) }}" class="category-tree_control-btn" title="{{ __('admin/categories.edit_category') }}">
                                                                    <svg viewBox="0 0 24 24">
                                                                        <use href="#categoriesEditIcon"/>
                                                                    </svg>
                                                                </a>
                                                            @endisset
                                                            <a href="{{ route('admin.categories.create', ['parent_id' => $cat_level3['id']]) }}" class="category-tree_control-btn" title="{{ __('admin/categories.add_child') }}">
                                                                <svg viewBox="0 0 24 24">
                                                                    <use href="#categoriesAddIcon"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    @isset($cat_level3['subcategories'])
                                                        <ul>
                                                            @foreach($cat_level3['subcategories'] as $cat_level4)
                                                                <li>
                                                                    <div class="category-tree_inner-item level{{ $cat_level4['level'] }}">
                                                                        <div class="category-tree_chevron-empty"></div>
                                                                        <a href="{{ route('admin.categories.edit', $cat_level4['id']) }}" class="category-tree_item-text" title="{{ __('admin/categories.edit_category') }}">
                                                                            <span class="category-tree_item-name level{{ $cat_level4['level'] }}">{{ $cat_level4['name'] }}</span>
                                                                            <span class="category-tree_products-num">{{ $cat_level4['product_count_all'] ?: '' }}</span>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endisset
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endisset
                                </li>
                            @endforeach
                        </ul>
                    @endisset
                </li>
            @endforeach

            <li>
                <a href="#" class="link category-tree_add-root-btn">{{ __('admin/categories.add_root') }}</a>
            </li>
        </ul>

    </div>
@endsection