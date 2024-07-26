@extends('admin.layout')

@section('page_title',  $shop->name . ' - ' . __('admin/shops.editing_shop') . ' - ' . __('admin/general.admin_panel'))

@section('page_back')
    <x-admin::back-link :url="route('admin.shops')" text="{{ __('admin/shops.shops') }}" />
@endsection

@section('page_header', __('admin/shops.editing_shop'))

@section('main_content')
    <div class="admin-main-page">
        <div class="mb-1">
            <span class="grey-text">ID {{ $shop->id }}:</span>
            {{ $shop->name }}
        </div>

        <div class="mb-3">
            <span class="grey-text">{{ __('admin/shops.orders_num') }}:</span>
            {{ $shop->orders_count }}
        </div>

        <div class="mb-4">
            <div class="preloader-cont" id="shopSwitchSection" data-id="{{ $shop->id }}">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="shopActiveSwitch" @checked($shop->is_active)>
                    <label class="form-check-label" for="shopActiveSwitch">{{ __('admin/shops.is_active') }}</label>
                </div>
                <img class="preloader pl-switch hidden" src="{{ asset('img/preloader.gif') }}" alt="">
            </div>
            <div class="small grey-text fst-italic">{{ __('admin/shops.is_active_note') }}</div>
        </div>

        <form class="mb-55" action="{{ route('admin.shops.update', $shop->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="name_{{ $lang->id }}" class="form-label">
                            {{ __('admin/shops.name') . ' (' . $lang->id . ')' }}:
                        </label>
                        <input type="text"
                               class="form-control @error('name.' . $lang->id) is-invalid @enderror"
                               name="name[{{ $lang->id }}]"
                               value="{{ old('name.' . $lang->id, $shop->getTranslation('name', $lang->id)) }}"
                               id="name_{{ $lang->id }}"/>
                        @error('name.' . $lang->id)
                        <div id="name_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="form-flex-cont mb-4">
                <div>
                    <label for="sort" class="form-label mb-0">
                        {{ __('admin/shops.sort') }}:
                    </label>
                    <div class="small grey-text fst-italic mb-2">{{ __('admin/shops.sort_note', ['num' => $shops_count]) }}</div>
                    <input type="hidden" name="sort_old" value="{{ $shop->sort }}">
                    <input type="text"
                           class="form-control @error('sort') is-invalid @enderror"
                           name="sort"
                           value="{{ old('sort', $shop->sort) }}"
                           id="sort">
                    @error('sort')
                    <div id="sortFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="address_{{ $lang->id }}" class="form-label">
                            {{ __('admin/shops.address') . ' (' . $lang->id . ')' }}:
                        </label>
                        <input type="text"
                               class="form-control @error('address.' . $lang->id) is-invalid @enderror"
                               name="address[{{ $lang->id }}]"
                               value="{{ old('address.' . $lang->id, $shop->getTranslation('address', $lang->id)) }}"
                               id="address_{{ $lang->id }}"/>
                        @error('address.' . $lang->id)
                        <div id="address_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="form-flex-cont mb-4">
                <div>
                    <label for="location" class="form-label mb-0">
                        {{ __('admin/shops.location') }}:
                    </label>
                    <div class="small grey-text fst-italic mb-2">{!! __('admin/shops.location_note', ['link' => '<a href="' . 'https://yandex.ru/map-constructor/location-tool/' . '" class="link">' . __('admin/shops.location_note_link_text') . '</a>']) !!}</div>
                    <input type="text"
                           class="form-control @error('location') is-invalid @enderror"
                           name="location"
                           value="{{ old('location', $shop->location_str) }}"
                           id="location"/>
                    @error('location')
                    <div id="locationFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-flex-cont mb-4">
                <div>
                    <label for="openingHours" class="form-label mb-0">
                        {{ __('admin/shops.opening_hours') }}:
                    </label>
                    <div class="small grey-text fst-italic mb-2">{{ __('admin/shops.opening_hours_note') }}</div>
                    <textarea class="form-control"
                           name="opening_hours"
                           id="openingHours">{{ $opening_hours_text }}</textarea>
                </div>
            </div>

            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="info_{{ $lang->id }}"
                               class="form-label">{{ __('admin/shops.info') . ' (' . $lang->id . ')' }}
                            :</label>
                        <textarea class="form-control @error('info.' . $lang->id) is-invalid @enderror"
                                  name="info[{{ $lang->id }}]"
                                  id="info_{{ $lang->id }}">{{ old('info.' . $lang->id, $shop->getTranslation('info', $lang->id)) }}</textarea>
                        @error('info.' . $lang->id)
                        <div id="info_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <button type="submit">{{ __('admin/general.save') }}</button>
        </form>


        @if($shop->orders_count)
            <div class="small fst-italic grey-text">{{ __('admin/shops.delete_note') }}</div>
        @else
            <form class="mb-4" action="{{ route('admin.shops.destroy', $shop->id) }}" method="POST" id="deleteShopForm">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn-bg-red mb-3" data-name="{{ $shop->name }}">{{ __('admin/shops.delete_shop') }}</button>
            </form>
        @endif
    </div>
@endsection