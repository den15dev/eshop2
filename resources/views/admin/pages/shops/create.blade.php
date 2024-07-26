@extends('admin.layout')

@section('page_title',  __('admin/shops.adding_shop') . ' - ' . __('admin/general.admin_panel'))

@section('page_back')
    <x-admin::back-link :url="route('admin.shops')" text="{{ __('admin/shops.shops') }}" />
@endsection

@section('page_header', __('admin/shops.adding_shop'))

@section('main_content')
    <div class="admin-main-page">
        <form class="mb-55" enctype="multipart/form-data" action="{{ route('admin.shops.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="is_active" role="switch" id="shopActiveSwitch">
                    <label class="form-check-label" for="shopActiveSwitch">{{ __('admin/shops.is_active') }}</label>
                </div>
                <div class="small grey-text fst-italic">{{ __('admin/shops.is_active_note') }}</div>
            </div>

            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="name_{{ $lang->id }}" class="form-label">
                            {{ __('admin/shops.name') . ' (' . $lang->id . ')' }}:
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
                    <label for="sort" class="form-label mb-0">
                        {{ __('admin/shops.sort') }}:
                    </label>
                    <div class="small grey-text fst-italic mb-2">{{ __('admin/shops.sort_note', ['num' => $shops_count]) }}</div>
                    <input type="text"
                           class="form-control @error('sort') is-invalid @enderror"
                           name="sort"
                           value="{{ old('sort', $shops_count + 1) }}"
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
                               value="{{ old('address.' . $lang->id) }}"
                               id="address_{{ $lang->id }}">
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
                           value="{{ old('location') }}"
                           id="location">
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
                                  id="info_{{ $lang->id }}">{{ old('info.' . $lang->id) }}</textarea>
                        @error('info.' . $lang->id)
                        <div id="info_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>


            <button type="submit">{{ __('admin/general.create') }}</button>
        </form>
    </div>
@endsection