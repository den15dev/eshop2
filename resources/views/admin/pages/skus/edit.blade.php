@extends('admin.layout')

@section('page_title',  $sku->name . ' - ' . __('admin/skus.editing_sku'))

@section('page_back')
    <x-admin::back-link :url="route('admin.products')" text="{{ __('admin/products.products') }}" />
@endsection

@section('page_header', __('admin/skus.editing_sku'))

@section('main_content')
    <div class="admin-main-page">
        <a href="{{ route('admin.products.edit', $sku->product_id) }}" class="link d-block mb-3">
            <span class="icon-chevron-left xsmall va1"></span>
            {{ __('admin/skus.to_product', ['product' => $sku->product->name]) }}
        </a>

        <div>
            <span class="grey-text">ID {{ $sku->id }}:</span>
            <a href="{{ $sku->url }}" class="link external-link" target="_blank">{{ $sku->name }}</a>
        </div>

        <div class="mb-3">
            <span class="grey-text">{{ __('product.sku_code') }}:</span> {{ $sku->code }}
        </div>


        <form class="mb-6" action="{{ route('admin.skus.update', $sku->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-flex-cont mb-4">
                <div>
                    <label for="availableFrom" class="form-label mb-0">{{ __('admin/skus.available_from') }}
                        :</label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/skus.available_from_note') }}
                    </div>
                    <input type="text"
                           class="form-control @error('available_from') is-invalid @enderror"
                           name="available_from"
                           value="{{ old('available_from', $sku->available_from?->isoFormat('YYYY-MM-DD, HH:mm')) }}"
                           id="availableFrom"/>
                    @error('available_from')
                    <div id="availableFromFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="availableUntil" class="form-label mb-0">{{ __('admin/skus.available_until') }}
                        :</label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/skus.available_until_note') }}
                    </div>
                    <input type="text"
                           class="form-control @error('available_until') is-invalid @enderror"
                           name="available_until"
                           value="{{ old('available_until', $sku->available_until?->isoFormat('YYYY-MM-DD, HH:mm')) }}"
                           id="availableUntil"/>
                    @error('available_until')
                    <div id="availableUntilFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit">{{ __('admin/general.save') }}</button>
        </form>


        @if($sku->product->attributes->count())
            <h5 class="mb-3">{{ __('admin/products.attributes') }}</h5>

            @if(session('attributes_error'))
                <div class="alert alert-warning">{{ session('attributes_error') }}</div>
            @endif

            <form class="mb-6" action="{{ route('admin.skus.update', $sku->id) }}" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" name="product_id" value="{{ $sku->product_id }}"/>

                <div class="form-flex-cont mb-4">
                    @foreach($sku->product->attributes as $attribute)
                        <div>
                            <label for="attribute_{{ $attribute->id }}" class="form-label">{{ $attribute->name }}
                                :</label>
                            <select name="attributes[{{ $attribute->id }}]" class="form-select"
                                    id="attribute_{{ $attribute->id }}">
                                @foreach($attribute->variants as $variant)
                                    <option value="{{ $variant->id }}"
                                            @selected(old('attributes.' . $attribute->id, $sku->variants->firstWhere('id', $variant->id)?->id) == $variant->id)>
                                        {{ $variant->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

                <button type="submit">{{ __('admin/general.save') }}</button>
            </form>
        @endif


        <form class="mb-6" action="{{ route('admin.skus.update', $sku->id) }}" method="POST" id="skuEditMainForm">
            @method('PUT')
            @csrf
            <h5 class="mb-3">{{ __('admin/skus.general_info') }}</h5>

            <div class="mb-4">
                @foreach($languages as $lang)
                    <div class="mb-3">
                        <label for="name_{{ $lang->id }}"
                               class="form-label">{{ __('admin/products.name') . ' (' . $lang->id . ')' }}:</label>
                        <input type="text"
                               class="form-control @error('name.' . $lang->id) is-invalid @enderror"
                               name="name[{{ $lang->id }}]"
                               value="{{ old('name.' . $lang->id, $sku->getTranslation('name', $lang->id)) }}"
                               id="name_{{ $lang->id }}"/>
                        @error('name.' . $lang->id)
                        <div id="name_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="form-flex-cont mb-4">
                <div>
                    <label for="sku" class="form-label">{{ __('product.manufacturer_code') }}:</label>
                    <input type="text"
                           class="form-control @error('sku') is-invalid @enderror"
                           name="sku"
                           value="{{ old('sku', $sku->sku) }}"
                           id="sku"/>
                    @error('sku')
                    <div id="skuFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="shortDescr_{{ $lang->id }}"
                               class="form-label">{{ __('admin/skus.short_descr') . ' (' . $lang->id . ')' }}
                            :</label>
                        <textarea class="form-control @error('short_descr.' . $lang->id) is-invalid @enderror"
                                  name="short_descr[{{ $lang->id }}]"
                                  id="shortDescr_{{ $lang->id }}">{{ old('short_descr.' . $lang->id, $sku->getTranslation('short_descr', $lang->id)) }}</textarea>
                        @error('short_descr.' . $lang->id)
                        <div id="shortDescr_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="description_{{ $lang->id }}"
                               class="form-label">{{ __('admin/skus.description') . ' (' . $lang->id . ')' }}
                            :</label>
                        <textarea class="form-control @error('description.' . $lang->id) is-invalid @enderror"
                                  name="description[{{ $lang->id }}]"
                                  id="description_{{ $lang->id }}">{{ old('description.' . $lang->id, $sku->getTranslation('description', $lang->id)) }}</textarea>
                        @error('description.' . $lang->id)
                        <div id="description_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="form-flex-cont mb-3">
                <div>
                    <label for="price" class="form-label">{{ __('admin/skus.price') }}:</label>
                    <input type="text"
                           class="form-control @error('price') is-invalid @enderror"
                           name="price"
                           value="{{ old('price', preg_replace('/(.+)[,.]00$/', '$1', $sku->price)) }}"
                           id="price"/>
                    @error('price')
                    <div id="priceFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="currency" class="form-label">{{ __('admin/skus.currency') }}:</label>
                    <select name="currency_id" class="form-select @error('currency') is-invalid @enderror"
                            id="currency">
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}"
                                    {{ $sku->currency_id === $currency->id ? 'selected' : '' }}>
                                {{ strtoupper($currency->id) }} ({{ $currency->name }})
                            </option>
                        @endforeach
                    </select>
                    @error('currency')
                    <div id="currencyFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-flex-cont mb-3">
                <div>
                    <label for="discount" class="form-label mb-0">{{ __('admin/skus.discount') }}:</label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/skus.discount_note') }}
                    </div>
                    <input type="text"
                           class="form-control @error('discount') is-invalid @enderror"
                           name="discount"
                           value="{{ old('discount', $sku->discount ?? '0') }}"
                           id="discount"/>
                    @error('discount')
                    <div id="discountFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-flex-cont mb-4" id="promoSection">
                <div>
                    <label for="promo" class="form-label">{{ __('admin/skus.promo') }}:</label>
                    <select name="promo_id" class="form-select @error('promo') is-invalid @enderror" id="promo">
                        <option value="" {{ $sku->promo_id ? '' : 'selected' }}>{{ __('admin/general.No') }}</option>
                        @foreach($promos as $promo)
                            <option value="{{ $promo->id }}"
                                    {{ $sku->promo_id === $promo->id ? 'selected' : '' }}
                                    data-discount="{{ $promo->discount }}"
                                    data-status="{{ $promo->status }}"
                                    data-status-human="{{ $promo->status_description }}">
                                {{ $promo->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('promo')
                    <div id="promoFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div @if(!$sku->promo) class="hidden" @endif id="promoInfo">
                        <div class="mt-2">
                            <span class="grey-text">{{ __('admin/skus.promo_discount') }}:</span>
                            <span id="promoDiscount">
                                @if($sku->promo)
                                    {{ $sku->promo->discount }}%
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="grey-text">{{ __('admin/skus.promo_status.status') }}:</span>
                            <span id="promoStatus" @if($sku->promo?->status === 'scheduled') class="text-scheduled" @endif>
                                @if($sku->promo)
                                    {{ $sku->promo->status_description }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4" id="finalPriceSection">
                <div>
                    <span class="grey-text">{{ __('admin/skus.final_discount') }}:</span>
                    <span id="finalDiscount">{{ $final_prices->discount }}</span>
                </div>
                @foreach($currencies as $currency)
                    <div>
                        @php
                            $currency_id = $currency->id;
                        @endphp
                        <span class="grey-text">{{ __('admin/skus.final_price') }} ({{ strtoupper($currency->id) }}):</span>
                        <span class="fw-semibold"
                              data-currency="{{ $currency->id }}">{!! $final_prices->$currency_id !!}</span>
                    </div>
                @endforeach
            </div>

            <button type="submit">{{ __('admin/general.save') }}</button>
        </form>


        <div class="mb-6">
            <h5 class="mb-2">{{ __('admin/skus.images.title') }}</h5>

            <div class="small grey-text fst-italic mb-4">
                {{ __('admin/skus.images.order_note') }}
            </div>

            <div class="sku-edit_images mb-4">
                @foreach($sku->images as $img_num)
                    <div class="sku-edit_image-item" data-id="{{ $img_num }}">
                        <div class="sku-edit_image-item_close-btn">
                            <svg>
                                <use href="#closeIcon"/>
                            </svg>
                        </div>
                        <a href="{{ $sku->getImageURL('lg', $img_num) }}" data-fancybox="sku_{{ $sku->id }}">
                            <img src="{{ $sku->getImageURL('sm', $img_num) }}" alt="">
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="form-flex-cont">
                <form enctype="multipart/form-data" method="POST" action="{{ route('admin.skus.update', $sku->id) }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="old_images"
                           value="{{ json_encode($sku->images, JSON_UNESCAPED_UNICODE) }}"/>
                    <input type="hidden" name="new_images"
                           value="{{ json_encode($sku->images, JSON_UNESCAPED_UNICODE) }}"
                           id="skuImages"/>
                    <input type="hidden" name="sku_code"
                           value="{{ $sku->code }}"/>

                    <div class="mb-3">
                        <input type="file"
                               class="form-control @if ($errors->get('image')) is-invalid @endif"
                               name="image"
                               id="skuNewImage"
                               accept=".jpg">
                        @if ($errors->get('image'))
                            <div class="invalid-feedback" id="skuNewImageFeedback">
                                {{ $errors->get('image')[0] }}
                            </div>
                        @endif
                    </div>

                    <div class="small grey-text fst-italic mb-3">
                        {{ __('admin/skus.images.upload_note') }}
                    </div>

                    <button type="submit" class="btn-inactive" id="newImageSubmitBtn"
                            disabled>{{ __('admin/general.save') }}</button>
                </form>
            </div>
        </div>


        <div class="mb-7" data-sku-id="{{ $sku->id }}" id="skuSpecifications">
            <h5 class="mb-3">{{ __('admin/specifications.specifications') }}</h5>

            <a href="{{ route('admin.categories.edit', $sku->category_id) }}" class="d-block link mb-3">
                {{ __('admin/specifications.category_specs_link', ['category' => $sku->category_name]) }}
            </a>

            <div class="small grey-text fst-italic mb-4">
                "{{ __('admin/specifications.is_filter') }}" — {{ __('admin/specifications.is_filter_note') }}<br>
                "{{ __('admin/specifications.is_main') }}" — {{ __('admin/specifications.is_main_note') }}
            </div>

            @foreach($category_specs as $cat_spec)
                <div class="spec-item">
                    <div class="spec-item_section">
                        <div class="small lightgrey-text">#{{ $cat_spec->sort }}</div>
                        <div class="mb-2">{{ $cat_spec->name }}{{ $cat_spec->units ? ', ' . $cat_spec->units : '' }}</div>
                        <div class="spec-item_checkboxes">
                            <div class="spec-item_checkbox-cont">
                                <input type="checkbox" class="form-check-input" name="is_filter[{{ $cat_spec->id }}]"
                                       id="isFilter{{ $cat_spec->id }}"
                                       {{ $cat_spec->is_filter ? 'checked' : '' }} disabled/>
                                <label class="form-check-label grey-text"
                                       for="isFilter{{ $cat_spec->id }}">{{ __('admin/specifications.is_filter') }}</label>
                            </div>

                            <div class="spec-item_checkbox-cont">
                                <input type="checkbox" class="form-check-input" name="is_main[{{ $cat_spec->id }}]"
                                       id="isMain{{ $cat_spec->id }}"
                                       {{ $cat_spec->is_main ? 'checked' : '' }} disabled/>
                                <label class="form-check-label grey-text"
                                       for="isMain{{ $cat_spec->id }}">{{ __('admin/specifications.is_main') }}</label>
                            </div>
                        </div>
                    </div>

                    <form class="spec-item_section mb-1" data-spec-id="{{ $cat_spec->id }}">
                        @foreach($languages as $lang)
                            <div class="spec-item_text-cont">
                                @php
                                    $id = 'spec' . $cat_spec->id . '_' . $lang->id;
                                @endphp
                                <label for="{{ $id }}" class="form-label">{{ $lang->id }}:</label>
                                <div>
                                    @php
                                        $spec_value = $sku->specifications->firstWhere('id', $cat_spec->id)?->pivot->getTranslation('spec_value', $lang->id, false);
                                    @endphp
                                    <textarea class="form-control" name="{{ $lang->id }}"
                                              id="{{ $id }}"
                                              data-minlines="1">{{ $spec_value }}</textarea>
                                    <div id="{{ $id }}Feedback" class="invalid-feedback"></div>
                                </div>
                            </div>
                        @endforeach

                        <div class="spec-item_btns">
                            <div class="grey-link spec-item_clear-btn">{{ __('admin/general.clear') }}</div>
                            <div class="link spec-item_save-btn">{{ __('admin/general.save') }}</div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>


        <form class="mb-6" action="{{ route('admin.skus.destroy', $sku->id) }}" method="POST" id="removeSkuForm">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn-bg-red mb-3">{{ __('admin/skus.delete_sku') }}</button>
            <div class="small fst-italic">
                <span class="fw-semibold">{{ __('admin/general.caution') }}</span>
                <span class="grey-text">{{ __('admin/skus.delete_sku_warning', ['available_until' => __('admin/skus.available_until')]) }}</span>
            </div>
        </form>
    </div>
@endsection
