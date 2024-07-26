@extends('admin.layout')

@section('page_title',  __('admin/promos.editing_promo') . ' ' . $promo->id . ' - ' . __('admin/general.admin_panel'))

@section('page_back')
    <x-admin::back-link :url="route('admin.promos')" text="{{ __('admin/promos.promos') }}" />
@endsection

@section('page_header', __('admin/promos.editing_promo'))

@section('main_content')
    <div class="admin-main-page">
        <div class="mb-3">
            <span class="grey-text">ID {{ $promo->id }}:</span>
            <a href="{{ $promo->url }}" class="link external-link" target="_blank">{{ $promo->name }}</a>
        </div>

        <div class="promo_status-badge {{ $status->id }} mb-4">{{ $status->description }}</div>

        <form class="mb-55" action="{{ route('admin.promos.update', $promo->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-flex-cont mb-4">
                <div>
                    <label for="startsAt" class="form-label mb-0">
                        {{ __('admin/promos.starts_at') }}:
                    </label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/promos.starts_at_sample') }}
                    </div>
                    <input type="text"
                           class="form-control @error('starts_at') is-invalid @enderror"
                           name="starts_at"
                           value="{{ old('starts_at', $promo->starts_at?->isoFormat('Y-MM-DD')) }}"
                           id="startsAt"/>
                    @error('starts_at')
                    <div id="startsAtFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="endsAt" class="form-label mb-0">
                        {{ __('admin/promos.ends_at') }}:
                    </label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/promos.ends_at_sample') }}
                    </div>
                    <input type="text"
                           class="form-control @error('ends_at') is-invalid @enderror"
                           name="ends_at"
                           value="{{ old('ends_at', $promo->ends_at?->isoFormat('Y-MM-DD')) }}"
                           id="endsAt"/>
                    @error('ends_at')
                    <div id="endsAtFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="mb-4">
                <input type="hidden" name="old_slug" value="{{ $promo->slug }}">

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
                        <label for="description{{ ucfirst($lang->id) }}"
                               class="form-label">{{ __('admin/promos.description') . ' (' . $lang->id . ')' }}:
                        </label>
                        <textarea class="form-control @error('description.' . $lang->id) is-invalid @enderror"
                                  name="description[{{ $lang->id }}]"
                                  id="description{{ ucfirst($lang->id) }}">{{ old('description.' . $lang->id, $promo->getTranslation('description', $lang->id)) }}</textarea>
                        @error('description.' . $lang->id)
                        <div id="description{{ ucfirst($lang->id) }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>


            <button type="submit">{{ __('admin/general.save') }}</button>
        </form>


        <form class="mb-6" enctype="multipart/form-data" action="{{ route('admin.promos.update', $promo->id) }}" method="POST" id="promoImagesForm">
            @method('PUT')
            @csrf
            <input type="hidden" name="slug" value="{{ $promo->slug }}">

            <div class="form-flex-cont mb-3">
                @foreach($languages as $lang)
                    <div>
                        <label for="image{{ ucfirst($lang->id) }}"
                               class="form-label">{{ __('admin/categories.image') . ' (' . $lang->id . ')' }}:
                        </label>
                        @if(file_exists($promo->getImagePath('md', $lang->id)))
                            <div class="mb-2">
                                <img src="{{ $promo->getImageURL('md', $lang->id) }}" class="w-100" alt="{{ $promo->getTranslation('name', $lang->id) }}" />
                            </div>
                        @endif
                        <input type="file"
                               class="form-control @error('image.' . $lang->id) is-invalid @enderror"
                               name="image[{{ $lang->id }}]"
                               id="image{{ ucfirst($lang->id) }}"
                               accept=".jpg,.png">
                        @error('image.' . $lang->id)
                            <div id="image{{ ucfirst($lang->id) }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="small grey-text fst-italic mb-3">{{ __('admin/promos.image_note') }}</div>

            <button type="submit" class="btn-inactive">{{ __('admin/general.save') }}</button>
        </form>


        @if($skus->count())
            <h5 class="mb-3">{{ __('admin/promos.products') }}</h5>

            <div class="mb-3" style="overflow-x: auto">
                <table class="table index-table" id="promoSkuTable">
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
                                <a href="{{ route('admin.skus.edit', $sku->id) }}" class="index-table_img-link">
                                    <img src="{{ $sku->getImageURL('tn') }}" alt="{{ $sku->name }}">
                                </a>
                            </td>
                            <td class="text-start">
                                <a href="{{ route('admin.skus.edit', $sku->id) }}" class="dark-link">{{ $sku->name }}</a>
                            </td>
                            <td>{{ $sku->discount ? $sku->discount . '%' : '-' }}</td>
                            <td data-id="{{ $sku->id }}">
                                <div class="promo_table-btn delete" title="{{ __('admin/general.delete') }}">
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


        <form class="mb-65" action="{{ route('admin.promos.update', $promo->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-flex-cont mb-3">
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

            <button type="submit">{{ __('admin/general.add') }}</button>
        </form>


        <form class="mb-4" action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" id="deletePromoForm">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn-bg-red mb-3" data-name="{{ $promo->name }}">{{ __('admin/promos.delete_promo') }}</button>
            <div class="small fst-italic">
                <span class="fw-semibold">{{ __('admin/general.caution') }}</span>
                <span class="grey-text">{{ __('admin/promos.delete_promo_warning') }}</span>
            </div>
        </form>
    </div>
@endsection