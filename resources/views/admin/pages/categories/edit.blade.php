@extends('admin.layout')

@section('page_title',  $category->name . ' - ' . __('admin/categories.editing_category'))

@section('page_header', __('admin/categories.editing_category'))

@section('main_content')
    <div class="admin-main-page">
        <div class="mb-3">
            <span class="grey-text">ID {{ $category->id }}:</span> {{ $category->name }}
        </div>

        <form class="mb-55" enctype="multipart/form-data" action="{{ route('admin.categories.update', $category->id) }}" method="POST">
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
                        {{ __('admin/categories.slug_note') }}
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


            @if($category->level > 1)
                <div class="form-flex-cont mb-45">
                    <div>
                        <label for="parentCategory" class="form-label mb-0">{{ __('admin/categories.parent_category') }}:</label>
                        <div class="small grey-text fst-italic mb-2">
                            {{ __('admin/categories.parent_note') }}
                        </div>
                        <input type="hidden" name="old_parent_id" class="hidden" value="{{ $category->id }}" />
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
            @endif


            @if($children->isNotEmpty())
                <div class="grey-text mt-2">{{ __('admin/categories.change_order') }}:</div>
                <div class="small grey-text fst-italic mb-2">
                    {{ __('admin/categories.order_note') }}
                </div>
                <input type="hidden" value="{{ json_encode($children->pluck('id')) }}" id="childCategoryOrderInput" />
                <ul class="mb-45 w-fit" id="childCategoryOrderList">
                    @foreach($children as $child)
                        <li class="category-edit_order-item" data-id="{{ $child->id }}">
                            {{ $child->name }}
                            <span class="lightgrey-text">{{ $child->sku_num_children_all ?: $child->sku_num_all }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif


            <div class="form-flex-cont mb-45">
                <div>
                    <label for="categoryImage" class="form-label">{{ __('admin/categories.image') }}:</label>

                    @if(file_exists($category->image_path))
                        <div class="mb-2">
                            <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}">
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


        @if($specs->count())
            <div class="mb-5" id="categorySpecifications">
                <h5 class="mb-3">{{ __('admin/specifications.title') }}</h5>

                <div class="small grey-text fst-italic mb-4">
                    "{{ __('admin/specifications.is_filter') }}" — {{ __('admin/specifications.is_filter_note') }}<br>
                    "{{ __('admin/specifications.is_main') }}" — {{ __('admin/specifications.is_main_note') }}
                </div>

                @foreach($specs as $cat_spec)
                    <form data-spec-id="{{ $cat_spec->id }}" data-category-id="{{ $category->id }}">
                        <div class="small lightgrey-text mb-1">#{{ $cat_spec->id }}, {{ __('admin/specifications.used_in', ['num' => $cat_spec->skus_count]) }}</div>

                        <div class="spec-item">
                            <div class="spec-item_section">
                                <div class="spec-item_label">{{ __('admin/categories.specs.name') }}:</div>
                                @foreach($languages as $lang)
                                    <div class="spec-item_text-cont">
                                        @php
                                            $id = 'specName' . $cat_spec->id . ucfirst($lang->id);
                                        @endphp
                                        <label for="{{ $id }}" class="form-label">{{ $lang->id }}:</label>
                                        <div>
                                            <textarea class="form-control" name="name[{{ $lang->id }}]"
                                                      id="{{ $id }}"
                                                      {!! $lang->id === app()->getLocale() ? 'data-current-name="true"' : '' !!}
                                                      data-minlines="1">{{ $cat_spec->getTranslation('name', $lang->id, false) }}</textarea>
                                            <div id="{{ $id }}Feedback" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="spec-item_section mb-2">
                                <div class="spec-item_subsection">
                                    <div>
                                        <div class="spec-item_label">{{ __('admin/categories.specs.units') }}:</div>
                                        @foreach($languages as $lang)
                                            <div class="spec-item_text-cont">
                                                @php
                                                    $id = 'specUnits' . $cat_spec->id . ucfirst($lang->id);
                                                @endphp
                                                <label for="{{ $id }}" class="form-label">{{ $lang->id }}:</label>
                                                <div>
                                                    <input type="text"
                                                           class="form-control @error('units.' . $lang->id) is-invalid @enderror"
                                                           name="units[{{ $lang->id }}]"
                                                           value="{{ old('units.' . $lang->id, $cat_spec->getTranslation('units', $lang->id, false)) }}"
                                                           id="{{ $id }}" />
                                                    <div id="{{ $id }}Feedback" class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div>
                                        <div class="mb-25">
                                            @php
                                                $id = 'specOrderNum' . $cat_spec->id;
                                            @endphp
                                            <label class="spec-item_label">{{ __('admin/categories.specs.order') }}:</label>
                                            <input type="hidden" name="old_sort" value="{{ $cat_spec->sort }}" />
                                            <input type="text"
                                                   class="form-control @error('sort') is-invalid @enderror"
                                                   name="sort"
                                                   value="{{ old('sort', $cat_spec->sort) }}"
                                                   id="{{ $id }}" />
                                            @error('sort')
                                            <div id="{{ $id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div>
                                            <div class="spec-item_checkbox-cont mb-1">
                                                <input type="checkbox" class="form-check-input" name="is_filter"
                                                       id="isFilter{{ $cat_spec->id }}" {{ $cat_spec->is_filter ? 'checked' : '' }} />
                                                <label class="form-check-label"
                                                       for="isFilter{{ $cat_spec->id }}">{{ __('admin/specifications.is_filter') }}</label>
                                            </div>

                                            <div class="spec-item_checkbox-cont mb-1">
                                                <input type="checkbox" class="form-check-input" name="is_main"
                                                       id="isMain{{ $cat_spec->id }}" {{ $cat_spec->is_main ? 'checked' : '' }} />
                                                <label class="form-check-label"
                                                       for="isMain{{ $cat_spec->id }}">{{ __('admin/specifications.is_main') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="spec-item_btns">
                                    <div class="link spec-item_save-btn">{{ __('admin/general.save') }}</div>
                                    <div class="red-link spec-item_delete-btn">{{ __('admin/general.delete') }}</div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        @endif

    </div>
@endsection