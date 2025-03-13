@extends('admin.layout')

@section('page_title',  __('admin/settings.new') . ' - ' . __('admin/general.admin_panel'))

@section('page_back')
    <x-admin::back-link :url="route('admin.settings')" text="{{ __('admin/settings.settings') }}" />
@endsection

@section('page_header', __('admin/settings.new'))

@section('main_content')
    <div>
        <form class="mb-55" action="{{ route('admin.settings.store') }}" method="POST">
            @csrf
            <div class="form-flex-cont mb-4">
                <div>
                    <label for="settingId" class="form-label">{{ __('admin/settings.create_form.id') }}:</label>
                    <div class="small grey-text fst-italic mb-2" style="margin-top: -0.25rem">
                        {{ __('admin/settings.create_form.id_note') }}
                    </div>
                    <input type="text"
                           class="form-control @error('id') is-invalid @enderror"
                           name="id"
                           value="{{ old('id') }}"
                           id="settingId" />
                    @error('id')
                    <div id="settingIdFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="name_{{ $lang->id }}"
                               class="form-label">{{ __('admin/settings.create_form.name') . ' (' . $lang->id . ')' }}:</label>
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
                    <label for="settingVal" class="form-label">{{ __('admin/settings.create_form.val') }}:</label>
                    <div class="small grey-text fst-italic mb-2" style="margin-top: -0.25rem">
                        {{ __('admin/settings.create_form.val_note') }}
                    </div>
                    <textarea class="form-control @error('val') is-invalid @enderror"
                              name="val"
                              id="settingVal">{{ old('val') }}</textarea>
                    @error('val')
                    <div id="settingValFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-flex-cont mb-4">
                <div>
                    <label for="settingDataType" class="form-label">{{ __('admin/settings.create_form.data_type') }}:</label>
                    <select name="data_type" class="form-select" id="settingDataType">
                        @php
                            $data_types = \App\Modules\Settings\Enums\DataType::cases();
                        @endphp
                        @foreach($data_types as $data_type)
                            <option value="{{ $data_type->value }}" @selected(old('data_type') == $data_type->value)>
                                {{ $data_type->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-flex-cont mb-4">
                @foreach($languages as $lang)
                    <div>
                        <label for="description_{{ $lang->id }}"
                               class="form-label">{{ __('admin/settings.create_form.description') . ' (' . $lang->id . ')' }}:</label>
                        <textarea class="form-control @error('description.' . $lang->id) is-invalid @enderror"
                                  name="description[{{ $lang->id }}]"
                                  id="description_{{ $lang->id }}">{{ old('description.' . $lang->id) }}</textarea>
                        @error('description.' . $lang->id)
                        <div id="description_{{ $lang->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <button type="submit">{{ __('admin/general.create') }}</button>
        </form>
    </div>
@endsection
