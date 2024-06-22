@extends('admin.layout')

@section('page_title',  __('admin/promos.editing_promo') . ' ' . $promo->id . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/promos.editing_promo'))

@section('main_content')
    <div class="admin-main-page">
        <div class="mb-3">
            <span class="grey-text">ID {{ $promo->id }}:</span> {{ $promo->name }}
        </div>

        <div class="promo_status-badge {{ $status->id }} mb-4">{{ $status->description }}</div>

        <form class="mb-55" action="{{ route('admin.promos.update', $promo->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-flex-cont mb-4">
                <div>
                    <label for="availableFrom" class="form-label mb-2">
                        {{ __('admin/promos.starts_at') }}:
                    </label>
                    <input type="text"
                           class="form-control @error('starts_at') is-invalid @enderror"
                           name="starts_at"
                           value="{{ old('starts_at', $promo->starts_at?->isoFormat('Y-MM-DD')) }}"
                           id="availableFrom"/>
                    @error('starts_at')
                    <div id="availableFromFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="availableUntil" class="form-label mb-2">
                        {{ __('admin/promos.ends_at') }}:
                    </label>
                    <input type="text"
                           class="form-control @error('ends_at') is-invalid @enderror"
                           name="ends_at"
                           value="{{ old('ends_at', $promo->ends_at?->isoFormat('Y-MM-DD')) }}"
                           id="availableUntil"/>
                    @error('ends_at')
                    <div id="availableUntilFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="mb-4">
                @foreach($languages as $lang)
                    <div class="mb-3">
                        <label for="name_{{ $lang->id }}" class="form-label">
                            {{ __('admin/promos.name') . ' (' . $lang->id . ')' }}:
                        </label>
                        <input type="text"
                               class="form-control @error('name.' . $lang->id) is-invalid @enderror"
                               name="name[{{ $lang->id }}]"
                               value="{{ old('name.' . $lang->id, $promo->getTranslation('name', $lang->id)) }}"
                               id="name_{{ $lang->id }}"/>
                        @error('name.' . $lang->id)
                        <div id="name_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>


            <div class="form-flex-cont mb-4">
                <div>
                    <label for="promoDiscount" class="form-label mb-0">{{ __('admin/promos.discount') }}, %:</label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/promos.discount_note') }}
                    </div>
                    <input type="text"
                           class="form-control @error('discount') is-invalid @enderror"
                           name="discount"
                           value="{{ old('discount', $promo->discount) }}"
                           id="promoDiscount" />
                    @error('discount')
                    <div id="promoDiscountFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="description_{{ $lang->id }}"
                               class="form-label">{{ __('admin/promos.description') . ' (' . $lang->id . ')' }}
                            :</label>
                        <textarea class="form-control @error('description.' . $lang->id) is-invalid @enderror"
                                  name="description[{{ $lang->id }}]"
                                  id="description_{{ $lang->id }}">{{ old('description.' . $lang->id, $promo->getTranslation('description', $lang->id)) }}</textarea>
                        @error('description.' . $lang->id)
                        <div id="description_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>


            <button type="submit">{{ __('admin/general.save') }}</button>
        </form>


        <form class="mb-6" enctype="multipart/form-data" action="{{ route('admin.promos.update', $promo->id) }}" method="POST">
            @method('PUT')
            @csrf
            <label for="promoImage" class="form-label">{{ __('admin/categories.image') }}:</label>

            <div class="mb-2">
                <picture>
                    <source srcset="{{ $promo->images->size_1296 }}" media="(min-width: 1140px)" />
                    <source srcset="{{ $promo->images->size_1140 }}" media="(min-width: 992px)" />
                    <source srcset="{{ $promo->images->size_992 }}" media="(min-width: 768px)" />
                    <img src="{{ $promo->images->size_788 }}" class="w-100" alt="{{ $promo->name }}" />
                </picture>
            </div>

            <div class="form-flex-cont mb-4">
                <div>
                    <div class="mb-3">
                        <input type="file"
                               class="form-control @if ($errors->get('image')) is-invalid @endif"
                               name="image"
                               id="promoImage"
                               accept=".jpg">
                        @if ($errors->get('image'))
                            <div class="invalid-feedback" id="promoImageFeedback">
                                {{ $errors->get('image')[0] }}
                            </div>
                        @endif
                    </div>

                    <div class="small grey-text fst-italic">
                        {{ __('admin/promos.image_note') }}
                    </div>
                </div>
            </div>


            <button type="submit">{{ __('admin/general.save') }}</button>
        </form>


        @if($skus->count())
            <h5 class="mb-3">{{ __('admin/promos.products') }}</h5>

            <div class="mb-3" style="overflow-x: auto">
                <table class="table index-table">
                    <thead>
                    <tr>
                        <td>id</td>
                        <td></td>
                        <td>{{ __('admin/products.name') }}</td>
                        <td>{{ __('admin/promos.sku_discount') }}</td>
                        <td></td>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($skus as $sku)
                        <tr>
                            <td>{{ $sku->id }}</td>
                            <td>
                                <a href="#" class="index-table_img-link">
                                    <img src="{{ $sku->getImage('tn') }}" alt="{{ $sku->name }}">
                                </a>
                            </td>
                            <td class="text-start">
                                <a href="#" class="dark-link">{{ $sku->name }}</a>
                            </td>
                            <td>{{ $sku->discount ? $sku->discount . '%' : '-' }}</td>
                            <td>
                                <div class="promo_table-btn" title="{{ __('admin/general.delete') }}">
                                    <svg viewBox="0 0 23 23"><use href="#closeIcon"/></svg>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="mb-3">{{ __('admin/promos.no_products') }}</div>
        @endif


        <form class="mb-6" action="{{ route('admin.promos.update', $promo->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-flex-cont mb-4">
                <div>
                    <label for="promoSkuIds" class="form-label mb-0">{{ __('admin/promos.add_ids') }}:</label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/promos.add_ids_note') }}
                    </div>
                    <input type="text"
                           class="form-control @error('sku_ids') is-invalid @enderror"
                           name="sku_ids"
                           value="{{ old('sku_ids') }}"
                           id="promoSkuIds" />
                    @error('sku_ids')
                    <div id="promoSkuIdsFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </form>


        <form class="mb-4" action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" id="deletePromoForm">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn-bg-red mb-3" data-name="{{ $promo->name }}">{{ __('admin/promos.delete_promo') }}</button>
        </form>
    </div>
@endsection