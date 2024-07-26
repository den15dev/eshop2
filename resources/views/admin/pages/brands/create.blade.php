@extends('admin.layout')

@section('page_title',  __('admin/brands.adding_brand') . ' - ' . __('admin/general.admin_panel'))

@section('page_back')
    <x-admin::back-link :url="route('admin.brands')" text="{{ __('admin/brands.brands') }}" />
@endsection

@section('page_header', __('admin/brands.adding_brand'))

@section('main_content')
    <div class="admin-main-page">
        <form class="mb-55" enctype="multipart/form-data" action="{{ route('admin.brands.store') }}" method="POST">
            @csrf
            <div class="form-flex-cont mb-4">
                <div>
                    <label for="brandName" class="form-label">{{ __('admin/brands.name') }}:</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           name="name"
                           value="{{ old('name') }}"
                           id="brandName" />
                    @error('name')
                    <div id="brandNameFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="form-flex-cont mb-4">
                <div>
                    <label for="brandSlug" class="form-label mb-0">Slug:</label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/general.slug_note') }}
                    </div>
                    <input type="text"
                           class="form-control @error('slug') is-invalid @enderror"
                           name="slug"
                           value="{{ old('slug') }}"
                           id="brandSlug" />
                    @error('slug')
                    <div id="brandSlugFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="description_{{ $lang->id }}"
                               class="form-label">{{ __('admin/brands.description') . ' (' . $lang->id . ')' }}:
                        </label>
                        <textarea class="form-control @error('description.' . $lang->id) is-invalid @enderror"
                                  name="description[{{ $lang->id }}]"
                                  id="description_{{ $lang->id }}">{{ old('description.' . $lang->id) }}</textarea>
                        @error('description.' . $lang->id)
                        <div id="description_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>


            <div class="form-flex-cont mb-5">
                <div>
                    <label for="categoryImage" class="form-label mb-2">{{ __('admin/brands.image') }}:</label>
                    <div class="mb-3">
                        <input type="file"
                               class="form-control @if ($errors->get('image')) is-invalid @endif"
                               name="image"
                               id="categoryImage"
                               accept=".svg,.png">
                        @if ($errors->get('image'))
                            <div class="invalid-feedback" id="categoryImageFeedback">
                                {{ $errors->get('image')[0] }}
                            </div>
                        @endif
                    </div>

                    <div class="small grey-text fst-italic">
                        {{ __('admin/brands.image_note') }}
                    </div>
                </div>
            </div>


            <button type="submit">{{ __('admin/general.create') }}</button>
        </form>
    </div>
@endsection