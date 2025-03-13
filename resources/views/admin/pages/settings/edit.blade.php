@extends('admin.layout')

@section('page_title',  __('admin/settings.settings') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/settings.settings'))

@section('main_content')
    <div id="settingsPage">
        @php
            $type = \App\Modules\Settings\Enums\DataType::class;
        @endphp

        @foreach($settings as $setting)
            @if($setting->data_type === $type::Boolean)
                <div class="mb-45">
                    <div class="preloader-cont">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="{{ $setting->id }}" @checked($setting->val)>
                            <label class="form-check-label" for="{{ $setting->id }}">{{ $setting->name }}</label>
                        </div>
                        <img class="preloader pl-switch hidden" src="{{ asset('img/preloader.gif') }}" alt="">
                    </div>
                    @if($setting->description)
                        <div class="small grey-text fst-italic">
                            {{ $setting->description }}
                        </div>
                    @endif
                </div>

            @else
                <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST" class="mb-45" style="max-width: 500px">
                    @method('PUT')
                    @csrf
                    <label for="{{ $setting->id }}" class="form-label" style="line-height: 1.375rem">
                        {{ $setting->name }}:
                    </label>

                    @if($setting->description)
                        <div class="small grey-text fst-italic mb-2" style="margin-top: -0.125rem">
                            {{ $setting->description }}
                        </div>
                    @endif

                    @if($setting->data_type === $type::Array)
                        <div class="mb-25">
                            <textarea class="form-control @error('val') is-invalid @enderror"
                                      name="val"
                                      id="{{ $setting->id }}">{{ old('val', $setting->array_text) }}</textarea>
                            @error('val')
                            <div id="{{ $setting->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    @else
                        <div class="mb-25">
                            <input type="text"
                                   class="form-control @error('val') is-invalid @enderror"
                                   name="val"
                                   value="{{ old('val', $setting->val) }}"
                                   id="{{ $setting->id }}" />
                            @error('val')
                            <div id="{{ $setting->id }}Feedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <input type="hidden" name="data_value" value="{{ $setting->data_type->value }}" />

                    <button type="submit">{{ __('admin/general.save') }}</button>
                </form>
            @endif
        @endforeach

        <a href="{{ route('admin.settings.create') }}" class="link link-add submit-403">
            {{ __('admin/settings.add') }}
        </a>
    </div>
@endsection
