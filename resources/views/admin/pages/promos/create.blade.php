@extends('admin.layout')

@section('page_title',  __('admin/promos.adding_promo') . ' - ' . __('admin/general.admin_panel'))

@section('page_back')
    <x-admin::back-link :url="route('admin.promos')" text="{{ __('admin/promos.promos') }}" />
@endsection

@section('page_header', __('admin/promos.adding_promo'))

@section('main_content')
    <div class="admin-main-page">
        <form class="mb-55" enctype="multipart/form-data" action="{{ route('admin.promos.store') }}" method="POST">
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
                           value="{{ old('starts_at') }}"
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
                           value="{{ old('ends_at') }}"
                           id="endsAt"/>
                    @error('ends_at')
                    <div id="endsAtFeedback" class="invalid-feedback">{{ $message }}</div>
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
                    <label for="promoDiscount" class="form-label mb-0">{{ __('admin/promos.discount') }}, %:</label>
                    <div class="small grey-text fst-italic mb-2">
                        {{ __('admin/promos.discount_note') }}
                    </div>
                    <input type="text"
                           class="form-control @error('discount') is-invalid @enderror"
                           name="discount"
                           value="{{ old('discount') }}"
                           id="promoDiscount" />
                    @error('discount')
                    <div id="promoDiscountFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="form-flex-cont mb-5">
                @foreach($languages as $lang)
                    <div>
                        <label for="description{{ ucfirst($lang->id) }}"
                               class="form-label">{{ __('admin/promos.description') . ' (' . $lang->id . ')' }}:
                        </label>
                        <textarea class="form-control @error('description.' . $lang->id) is-invalid @enderror"
                                  name="description[{{ $lang->id }}]"
                                  id="description{{ ucfirst($lang->id) }}">{{ old('description.' . $lang->id) }}</textarea>
                        @error('description.' . $lang->id)
                        <div id="description{{ ucfirst($lang->id) }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>


            <div class="mb-5">
                <div class="form-flex-cont mb-3">
                    @foreach($languages as $lang)
                        <div>
                            <label for="image{{ ucfirst($lang->id) }}"
                                   class="form-label">{{ __('admin/categories.image') . ' (' . $lang->id . ')' }}:
                            </label>
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


                <div class="small grey-text fst-italic">{{ __('admin/promos.image_note') }}</div>
            </div>


            <div class="form-flex-cont mb-5">
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


            <button type="submit">{{ __('admin/general.create') }}</button>
        </form>
    </div>
@endsection