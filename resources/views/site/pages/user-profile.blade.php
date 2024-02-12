@extends('site.layout')

@section('page_title', __('user-profile.profile') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h3 class="mb-4">{{ __('user-profile.profile') }}</h3>

        <div class="row mb-5">
            <form class="col-12 col-lg-5" enctype="multipart/form-data" method="POST" action="{{ route('profile.store') }}">
                @csrf
                <div class="grey-text">{{ __('user-profile.labels.photo') }}</div>
                <div class="small grey-text fst-italic mb-2">
                    {{ __('user-profile.photo_size_note', ['num' => 5]) }}<br>
                    {{ __('user-profile.photo_res_note', ['num' => 5000]) }}
                </div>
                @if($user->image)
                    <img src="{{ asset('storage/images/users/' . $user->id . '/' . $user->image) }}" class="mb-3" style="max-width: 300px">
                @endif
                <div class="mb-3">
                    <input type="file" class="form-control @if ($errors->get('user_image')) is-invalid @endif" name="user_image" accept=".jpg,.png" aria-label="user image">
                    @if ($errors->get('user_image'))
                        <div class="invalid-feedback">
                            {{ $errors->get('user_image')[0] }}
                        </div>
                    @endif
                </div>

                <button type="submit">{{ __('user-profile.save') }}</button>
            </form>
        </div>


        <div class="row">
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>
            @endif

            <form class="col-12 col-lg-5 mb-6 me-auto" method="POST" action="{{ route('profile.store') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="nameInput" class="form-label grey-text">{{ __('user-profile.labels.name') }}:</label>
                    <input type="text" name="name" class="form-control @if ($errors->get('name')) is-invalid @endif" id="nameInput" value="{{ old('name', $user->name) }}">
                    @if ($errors->get('name'))
                        <div class="invalid-feedback">
                            {{ $errors->get('name')[0] }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="emailInput" class="form-label grey-text">{{ __('user-profile.labels.email') }}:</label>
                    <input type="email" name="email" class="form-control @if ($errors->get('email')) is-invalid @endif" id="emailInput" value="{{ old('email', $user->email) }}" autocomplete="username">
                    @if ($errors->get('email'))
                        <div class="invalid-feedback">
                            {{ $errors->get('email')[0] }}
                        </div>
                    @endif

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail)
                        @if($user->hasVerifiedEmail())
                            <div class="profile_verification verified mt-2 mb-2">
                                <span class="icon-check-lg me-1"></span>{{ __('user-profile.verification.verified') }}
                            </div>
                        @else
                            <div class="profile_verification mt-2 mb-2">
                                {{ __('user-profile.verification.not_verified') }}
                            </div>
                            <button type="submit" form="send-verification" class="btn-bg-grey">{{ __('user-profile.verification.send_link') }}</button>
                            @if (session('status') === 'verification-link-sent')
                                <div class="profile_link-sent mt-2">
                                    {{ __('user-profile.verification.link_sent') }}
                                </div>
                            @endif
                        @endif
                    @endif
                </div>

                <div class="mb-3">
                    <label for="phoneInput" class="form-label grey-text">{{ __('user-profile.labels.phone') }}:</label>
                    <input type="tel" name="phone" class="form-control @if ($errors->get('phone')) is-invalid @endif" id="phoneInput" value="{{ old('phone', $user->phone ?? '') }}">
                    @if ($errors->get('phone'))
                        <div class="invalid-feedback">
                            {{ $errors->get('phone')[0] }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="delAddrInput" class="form-label grey-text">{{ __('user-profile.labels.delivery_address') }}:</label>
                    <input type="text" name="address" class="form-control @if ($errors->get('address')) is-invalid @endif" id="delAddrInput" value="{{ old('address', $user->address ?? '') }}">
                    @if ($errors->get('address'))
                        <div class="invalid-feedback">
                            {{ $errors->get('address')[0] }}
                        </div>
                    @endif
                </div>

                <button type="submit">{{ __('user-profile.save') }}</button>
            </form>


            <form class="col-12 col-lg-5 mb-6 ms-0 me-auto" method="POST" action="{{ route('profile.store') }}" novalidate>
                @csrf
                {{-- ----- For browser password managers ----- --}}
                <input style="display: none" type="email" name="username" value="{{ old('email', $user->email) }}" autocomplete="username">
                {{-- ----------------------------------------- --}}

                <div class="mb-3">
                    <label for="currentPasswordInput" class="form-label grey-text">{{ __('user-profile.labels.current_password') }}:</label>
                    <div class="password-eye_cont">
                        <input type="password" name="current_password" class="form-control @if ($errors->get('current_password')) is-invalid @endif" autocomplete="current-password" id="currentPasswordInput">
                        @if ($errors->get('current_password'))
                            <div class="invalid-feedback">
                                {{ $errors->get('current_password')[0] }}
                            </div>
                        @endif
                        <div class="password-eye_show"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="newPasswordInput" class="form-label grey-text">{{ __('user-profile.labels.new_password') }}:</label>
                    <input type="password" name="new_password" class="form-control @if ($errors->get('new_password')) is-invalid @endif" autocomplete="new-password" id="newPasswordInput">
                    @if ($errors->get('new_password'))
                        <div class="invalid-feedback">
                            {{ $errors->get('new_password')[0] }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="newPasswordConfirmInput" class="form-label grey-text">{{ __('user-profile.labels.password_confirm') }}:</label>
                    <input type="password" name="new_password_confirmation" class="form-control @if ($errors->get('new_password_confirmation')) is-invalid @endif" autocomplete="new-password" id="newPasswordConfirmInput">
                    @if ($errors->get('new_password_confirmation'))
                        <div class="invalid-feedback">
                            {{ $errors->get('new_password_confirmation')[0] }}
                        </div>
                    @endif
                </div>

                <button type="submit">{{ __('user-profile.save') }}</button>
            </form>
        </div>

    </div>
@endsection