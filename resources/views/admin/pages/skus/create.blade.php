@extends('admin.layout')

@section('page_title',  __('admin/skus.adding_sku') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/skus.adding_sku'))

@section('main_content')
    <div class="admin-main-page">
        <a href="{{ route('admin.products.edit', $product->id) }}" class="link d-block mb-3">
            <span class="icon-chevron-left xsmall va1"></span>
            {{ __('admin/skus.to_product', ['product' => $product->name]) }}
        </a>

        <form class="mb-5" enctype="multipart/form-data" action="{{ route('admin.skus.store') }}" method="POST" id="skuCreateForm">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}" />

            <div class="form-flex-cont mb-5">
                <div>
                    <label for="availableFrom" class="form-label mb-0">
                        {{ __('admin/skus.available_from') }}:
                    </label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/skus.available_from_note') }}
                    </div>
                    <input type="text"
                           class="form-control @error('available_from') is-invalid @enderror"
                           name="available_from"
                           value="{{ old('available_from', now()->isoFormat('YYYY-MM-DD, HH:mm')) }}"
                           id="availableFrom"/>
                    @error('available_from')
                    <div id="availableFromFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="availableUntil" class="form-label mb-0">
                        {{ __('admin/skus.available_until') }}:
                    </label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/skus.available_until_note') }}
                    </div>
                    <input type="text"
                           class="form-control @error('available_until') is-invalid @enderror"
                           name="available_until"
                           value="{{ old('available_until') }}"
                           id="availableUntil"/>
                    @error('available_until')
                    <div id="availableUntilFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            @if($product->attributes->count())
                <h5 class="mb-25">{{ __('admin/products.attributes') }}</h5>

                @if(session('attributes_error'))
                    <div class="alert alert-warning">{{ session('attributes_error') }}</div>
                @endif

                <div class="form-flex-cont mb-5">
                    @foreach($product->attributes as $attribute)
                        <div>
                            <label for="attribute_{{ $attribute->id }}" class="form-label">{{ $attribute->name }}
                                :</label>
                            <select name="attributes[{{ $attribute->id }}]" class="form-select"
                                    id="attribute_{{ $attribute->id }}">
                                @foreach($attribute->variants as $variant)
                                    <option value="{{ $variant->id }}" @selected(old('attributes.' . $attribute->id))>
                                        {{ $variant->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            @endif


            <h5 class="mb-3">{{ __('admin/skus.general_info') }}</h5>

            <div class="mb-4">
                @foreach($languages as $lang)
                    <div class="mb-3">
                        <label for="name_{{ $lang->id }}"
                               class="form-label">{{ __('admin/products.name') . ' (' . $lang->id . ')' }}:</label>
                        <input type="text"
                               class="form-control @error('name.' . $lang->id) is-invalid @enderror"
                               name="name[{{ $lang->id }}]"
                               value="{{ old('name.' . $lang->id) }}"
                               id="name_{{ $lang->id }}"/>
                        @error('name.' . $lang->id)
                        <div id="name_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="form-flex-cont mb-4">
                <div>
                    <label for="sku" class="form-label">{{ __('admin/skus.sku') }}:</label>
                    <input type="text"
                           class="form-control @error('sku') is-invalid @enderror"
                           name="sku"
                           value="{{ old('sku') }}"
                           id="sku"/>
                    @error('sku')
                    <div id="skuFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="shortDescr_{{ $lang->id }}" class="form-label">
                            {{ __('admin/skus.short_descr') . ' (' . $lang->id . ')' }}:
                        </label>
                        <textarea class="form-control @error('short_descr.' . $lang->id) is-invalid @enderror"
                                  name="short_descr[{{ $lang->id }}]"
                                  id="shortDescr_{{ $lang->id }}"
                                  data-minlines="1">{{ old('short_descr.' . $lang->id) }}</textarea>
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
                                  id="description_{{ $lang->id }}">{{ old('description.' . $lang->id) }}</textarea>
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
                           value="{{ old('price', 0) }}"
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
                            <option value="{{ $currency->id }}" @selected(old('currency_id') == $currency->id)>
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
                           value="{{ old('discount', 0) }}"
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
                        <option value="" selected>{{ __('admin/general.No') }}</option>
                        @foreach($promos as $promo)
                            <option value="{{ $promo->id }}"
                                    @selected(old('promo_id') == $promo->id)
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

                    <div class="hidden" id="promoInfo">
                        <div class="mt-2">
                            <span class="grey-text">{{ __('admin/skus.promo_discount') }}:</span>
                            <span id="promoDiscount"></span>
                        </div>
                        <div>
                            <span class="grey-text">{{ __('admin/skus.promo_status.status') }}:</span>
                            <span id="promoStatus"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5" id="finalPriceSection">
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
                        <span class="fw-semibold" data-currency="{{ $currency->id }}">{!! $final_prices->$currency_id !!}</span>
                    </div>
                @endforeach
            </div>


            <h5 class="mb-3">{{ __('admin/skus.images.title') }}</h5>

            @error('images')
            <div class="alert alert-warning">{{ $message }}</div>
            @enderror

            <div class="form-flex-cont mb-5">
                <div>
                    <div class="create-sku_image mb-3">
                        <input type="file" class="form-control" name="images[01]" id="skuNewImage_01" accept=".jpg">
                    </div>

                    <div class="btn btn-bg-grey btn-add mb-3" id="addImageBtn">{{ __('admin/general.add') }}</div>

                    <div class="small grey-text fst-italic">
                        {{ __('admin/skus.images.upload_note') }}
                    </div>
                </div>
            </div>



            <div class="mb-4">
                <h5 class="mb-3">{{ __('admin/specifications.specifications') }}</h5>

                <a href="{{ route('admin.categories.edit', $product->category_id) }}" class="d-block link mb-3">
                    {{ __('admin/specifications.category_specs_link', ['category' => $product->category_name]) }}
                </a>

                <div class="small grey-text fst-italic mb-4">
                    "{{ __('admin/specifications.is_filter') }}" — {{ __('admin/specifications.is_filter_note') }}<br>
                    "{{ __('admin/specifications.is_main') }}" — {{ __('admin/specifications.is_main_note') }}
                </div>

                @foreach($category_specs as $cat_spec)
                    <div class="spec-item">
                        <div class="spec-item_section">
                            <div class="mb-2">{{ $cat_spec->name }}{{ $cat_spec->units ? ', ' . $cat_spec->units : '' }}</div>
                            <div class="spec-item_checkboxes">
                                <div class="spec-item_checkbox-cont">
                                    <input type="checkbox" class="form-check-input" name="is_filter[{{ $cat_spec->id }}]"
                                           id="isFilter{{ $cat_spec->id }}" {{ $cat_spec->is_filter ? 'checked' : '' }} disabled />
                                    <label class="form-check-label grey-text"
                                           for="isFilter{{ $cat_spec->id }}">{{ __('admin/specifications.is_filter') }}</label>
                                </div>

                                <div class="spec-item_checkbox-cont">
                                    <input type="checkbox" class="form-check-input" name="is_main[{{ $cat_spec->id }}]"
                                           id="isMain{{ $cat_spec->id }}" {{ $cat_spec->is_main ? 'checked' : '' }} disabled />
                                    <label class="form-check-label grey-text"
                                           for="isMain{{ $cat_spec->id }}">{{ __('admin/specifications.is_main') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="spec-item_section mb-1">
                            @foreach($languages as $lang)
                                <div class="spec-item_text-cont">
                                    @php
                                        $id = 'spec' . $cat_spec->id . '_' . $lang->id;
                                        $field_id = 'specs.' . $cat_spec->id . '.' . $lang->id;
                                    @endphp
                                    <label for="{{ $id }}" class="form-label">{{ $lang->id }}:</label>
                                    <div>
                                        <textarea class="form-control @error($field_id) is-invalid @enderror" name="specs[{{ $cat_spec->id }}][{{ $lang->id }}]"
                                                  id="{{ $id }}"
                                                  data-minlines="1">{{ old($field_id) }}</textarea>
                                        @error($field_id)
                                        <div id="{{ $id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>



            <button type="submit">{{ __('admin/products.add_sku') }}</button>
        </form>
    </div>
@endsection