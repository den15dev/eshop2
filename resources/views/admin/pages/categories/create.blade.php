@extends('admin.layout')

@section('page_title',  __('admin/categories.creating_category') . ' - ' . __('admin/general.admin_panel'))

@section('page_back')
    <x-admin::back-link :url="route('admin.categories')" text="{{ __('admin/categories.categories') }}" />
@endsection

@section('page_header', __('admin/categories.creating_category'))

@section('main_content')
    <div class="admin-main-page">
        <form class="mb-55" action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-flex-cont mb-45">
                <div>
                    <label for="parentCategory" class="form-label mb-2">{{ __('admin/categories.parent_category') }}:</label>
                    <select name="parent_id" class="form-select" id="parentCategory">
                        @foreach($categories as $cat)
                            @php
                                $value = $cat->level
                                    ? str_repeat('-', $cat->level - 1) . ' ' . $cat->name . ' (' . ($cat->sku_num_children_all ?: $cat->sku_num_all) . ')'
                                    : $cat->name;
                            @endphp
                            <option value="{{ $cat->id }}"
                                    {!! $cat->can_be_parent ? '' : 'class="lightgrey-text" disabled' !!}
                                    @selected(old('parent_id', $parent_id) == $cat->id)>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-flex-cont mb-45">
                @foreach($languages as $lang)
                    <div>
                        <label for="categoryName_{{ $lang->id }}" class="form-label">{{ __('admin/categories.name') . ' (' . $lang->id . ')' }}:</label>
                        <input type="text"
                               class="form-control @error('name.' . $lang->id) is-invalid @enderror"
                               name="name[{{ $lang->id }}]"
                               value="{{ old('name.' . $lang->id) }}"
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
                           value="{{ old('slug') }}"
                           id="categorySlug" />
                    @error('slug')
                    <div id="categorySlugFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="form-flex-cont mb-4">
                <div>
                    <label for="categoryImage" class="form-label">{{ __('admin/categories.image') }}:</label>
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


            <div class="admin-note mb-45">{{ __('admin/categories.create_specs_note') }}</div>


            <button type="submit">{{ __('admin/general.create') }}</button>
        </form>
    </div>
@endsection