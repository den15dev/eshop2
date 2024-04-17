@extends('emails.layout')

@section('page_title', __('notifications.reset_password.subject'))

@section('main_content')
    <h3 style="margin-top: 0; font-size: 18px;">{{ __('notifications.greeting', ['name' => $user->name]) }}</h3>

    <p>{{ __('notifications.reset_password.body1') }}</p>

    <p style="text-align: center; margin: 28px auto;">
        <a href="{{ $url }}" target="_blank" style="display: inline-block; border-radius: 6px; padding: 8px 24px; text-decoration: none; background-color: #716EF6; color: white;">{{ __('notifications.reset_password.button') }}</a>
    </p>

    <p>{{ __('notifications.reset_password.body2') }}</p>

    <p>{{ __('notifications.reset_password.body3') }}</p>

    <p>{{ __('notifications.signature1') }}<br>{{ __('notifications.signature2') }}</p>

    <div style="width: 100%; height: 1px; background-color: #e6e6e6; margin: 24px auto;"></div>

    <p style="font-size: 14px;">
        {{ __('notifications.reset_password.body_issues') }}
        <a href="{{ $url }}" style="color: #716EF6; word-break: break-all;">{{ $url }}</a>
    </p>
@endsection

@section('footer'){!! __('notifications.reset_password.footer', ['link' => $footer_home_link]) !!}@endsection