@extends('admin.layout')

@section('page_title',  $category->name . ' - ' . __('admin/categories.editing_category'))

@section('page_header', __('admin/categories.editing_category'))

@section('main_content')
    <div class="admin-main-page">
        <div class="mb-3">
            <span class="grey-text">ID {{ $category->id }}:</span> {{ $category->name }}
        </div>

        <form class="mb-55" action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-flex-cont mb-45">
                @foreach($languages as $lang)
                    <div>
                        <label for="categoryName_{{ $lang->id }}" class="form-label">{{ __('admin/categories.name') . ' (' . $lang->id . ')' }}:</label>
                        <input type="text"
                               class="form-control @error('name.' . $lang->id) is-invalid @enderror"
                               name="name[{{ $lang->id }}]"
                               value="{{ old('name.' . $lang->id, $category->getTranslation('name', $lang->id, false)) }}"
                               id="categoryName_{{ $lang->id }}" />
                        @error('name.' . $lang->id)
                        <div id="categoryName_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>


            <div class="form-flex-cont mb-45">
                <div>
                    <label for="categorySlug" class="form-label mb-0">Slug:</label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/general.slug_note') }}
                    </div>
                    <input type="text"
                           class="form-control @error('slug') is-invalid @enderror"
                           name="slug"
                           value="{{ old('slug', $category->slug) }}"
                           id="categorySlug" />
                    @error('slug')
                    <div id="categorySlugFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit">{{ __('admin/general.save') }}</button>
        </form>

        @if($category->level > 1)
            <form class="mb-55" action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-flex-cont mb-4">
                    <div>
                        <label for="parentCategory" class="form-label mb-0">{{ __('admin/categories.parent_category') }}:</label>
                        <div class="small grey-text fst-italic mb-2">
                            {{ __('admin/categories.parent_note') }}
                        </div>
                        <select name="parent_id" class="form-select" id="parentCategory">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                        {!! $cat->can_be_parent ? '' : 'class="lightgrey-text" disabled' !!}
                                        @selected(old('parent_id', $category->parent_id) == $cat->id)>
                                    {{ str_repeat('-', $cat->level - 1) . ' ' . $cat->name }} ({{ $cat->sku_num_children_all ?: $cat->sku_num_all }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit">{{ __('admin/general.save') }}</button>
            </form>
        @endif


        @if($children->isNotEmpty())
            <form class="mb-55" action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="grey-text mt-2">{{ __('admin/categories.change_order') }}:</div>
                <div class="small grey-text fst-italic mb-2">
                    {{ __('admin/categories.order_note') }}
                </div>
                <input type="hidden" name="old_children_order" value="{{ json_encode($children->pluck('id')) }}" />
                <input type="hidden" name="children_order" value="{{ json_encode($children->pluck('id')) }}" id="childCategoryOrderInput" />
                <ul class="mb-4 w-fit" id="childCategoryOrderList">
                    @foreach($children as $child)
                        <li class="category-edit_order-item" data-id="{{ $child->id }}">
                            {{ $child->name }}
                            <span class="lightgrey-text">{{ $child->sku_num_children_all ?: $child->sku_num_all }}</span>
                        </li>
                    @endforeach
                </ul>

                <button type="submit">{{ __('admin/general.save') }}</button>
            </form>
        @endif


        <form class="mb-55" enctype="multipart/form-data" action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-flex-cont mb-4">
                <div>
                    <label for="categoryImage" class="form-label">{{ __('admin/categories.image') }}:</label>

                    @if(file_exists($category->image_path))
                        <div class="mb-2">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                        </div>
                    @endif

                    <div class="mb-3">
                        <input type="file"
                               class="form-control @if ($errors->get('image')) is-invalid @endif"
                               name="image"
                               id="categoryImage"
                               accept=".jpg">
                        @if ($errors->get('image'))
                            <div class="invalid-feedback" id="categoryImageFeedback">
                                {{ $errors->get('image')[0] }}
                            </div>
                        @endif
                    </div>

                    <div class="small grey-text fst-italic">
                        {{ __('admin/categories.image_note') }}
                    </div>
                </div>
            </div>


            <button type="submit">{{ __('admin/general.save') }}</button>
        </form>


        <div class="mb-55">
            <h5 class="mb-3">{{ __('admin/categories.category_info') }}</h5>

            @if($category->sku_num_all)
                <div>
                    <span class="grey-text">{{ __('admin/categories.sku_num') }}:</span>
                    {{ $category->sku_num_all }}
                </div>
            @else
                <div class="grey-text">{{ __('admin/categories.no_sku') }}</div>
            @endif

            @if($parent)
                <div class="grey-text mt-2">{{ __('admin/categories.parent_category') }}:</div>
                <div class="ms-3 mb-2">
                    <a href="{{ route('admin.categories.edit', $parent->id) }}" class="link">{{ $parent->name }}</a>
                    <span>{{ $parent->sku_num_children_all }}</span>
                </div>
            @endif

            @if($children->isNotEmpty())
                <div class="grey-text mt-2">{{ __('admin/categories.child_categories') }}:</div>
                <ul class="mb-2">
                    @foreach($children as $child)
                        <li class="category-edit_child-item">
                            <a href="{{ route('admin.categories.edit', $child->id) }}" class="link">{{ $child->name }}</a>
                            <span>{{ $child->sku_num_children_all ?: $child->sku_num_all }}</span>
                        </li>
                    @endforeach
                </ul>

                <div>
                    <span class="grey-text">{{ __('admin/categories.children_sku_num') }}:</span>
                    {{ $category->sku_num_children_all }}
                </div>
            @else
                <div class="grey-text">{{ __('admin/categories.no_children') }}</div>
            @endif
        </div>


        @if(($category->level === 3 || $category->level === 4) && !$children->count())
            <div class="mb-4" id="categorySpecifications" data-category-id="{{ $category->id }}">
                <h5 class="mb-3">{{ __('admin/specifications.specifications') }} <span class="fw-normal lightgrey-text">({{ $specs->count() }})</span></h5>

                <div class="small grey-text fst-italic mb-4">
                    "{{ __('admin/specifications.is_filter') }}" — {{ __('admin/specifications.is_filter_note') }}<br>
                    "{{ __('admin/specifications.is_main') }}" — {{ __('admin/specifications.is_main_note') }}
                </div>

                @foreach($specs as $cat_spec)
                    <x-admin::category-specification-form :spec="$cat_spec" :languages="$languages" />
                @endforeach
            </div>

            <div class="mb-6" id="categoryAddSpec">
                <div class="mb-25 fw-semibold">{{ __('admin/specifications.add_spec') }}:</div>
                <x-admin::category-specification-form :languages="$languages" :specnum="$specs->count()" />
            </div>
        @endif


        <form class="mb-4" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" id="deleteCategoryForm">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn-bg-red mb-3 {{ ($category->has_children || $category->sku_num_all) ? 'btn-inactive' : '' }}" data-name="{{ $category->name }}">{{ __('admin/categories.delete_category') }}</button>
            <div class="small fst-italic">
                <span class="fw-semibold">{{ __('admin/general.caution') }}</span>
                <span class="grey-text">{{ __('admin/categories.delete_warning') }}</span>
            </div>
        </form>
    </div>
@endsection