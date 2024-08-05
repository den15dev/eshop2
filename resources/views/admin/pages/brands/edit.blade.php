@extends('admin.layout')

@section('page_title',  $brand->name . ' - ' . __('admin/brands.editing_brand') . ' ' . __('admin/general.admin_panel'))

@section('page_back')
    <x-admin::back-link :url="route('admin.brands')" text="{{ __('admin/brands.brands') }}" />
@endsection

@section('page_header', __('admin/brands.editing_brand'))

@section('main_content')
    <div>
        <div class="mb-3">
            <span class="grey-text">ID {{ $brand->id }}:</span>
            <a href="{{ $brand->url }}" class="link external-link" target="_blank">{{ $brand->name }}</a>
        </div>

        <form class="mb-55" action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-flex-cont mb-4">
                <div>
                    <label for="brandName" class="form-label">{{ __('admin/brands.name') }}:</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           name="name"
                           value="{{ old('name', $brand->name) }}"
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
                           value="{{ old('slug', $brand->slug) }}"
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
                                  id="description_{{ $lang->id }}">{{ old('description.' . $lang->id, $brand->getTranslation('description', $lang->id)) }}</textarea>
                        @error('description.' . $lang->id)
                        <div id="description_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>


            <button type="submit">{{ __('admin/general.save') }}</button>
        </form>


        <form class="mb-5" enctype="multipart/form-data" action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-flex-cont mb-4">
                <div>
                    <label for="categoryImage" class="form-label mb-2">{{ __('admin/brands.image') }}:</label>

                    @isset($brand->image_url)
                    <div class="mb-2" style="width: 320px">
                        <img src="{{ $brand->image_url }}" class="w-100" alt="{{ $brand->name }}">
                    </div>
                    @endisset

                    <div class="mb-2">
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


            <button type="submit">{{ __('admin/general.save') }}</button>
        </form>


        <div class="mb-5">
            @if($product_num)
                {{ __('admin/brands.product_count', ['product_num' => trans_choice('admin/brands.product_num', $product_num), 'sku_num' => $sku_num]) }}
            @else
                {{ __('admin/brands.no_products') }}
            @endif
        </div>


        <form class="mb-4" action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" id="deleteBrandForm">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn-bg-red mb-3 {{ $product_num ? 'btn-inactive' : '' }}" data-name="{{ $brand->name }}">{{ __('admin/brands.delete_brand') }}</button>
            <div class="small fst-italic">
                <span class="grey-text">{{ __('admin/brands.delete_warning') }}</span>
            </div>
        </form>
    </div>
@endsection