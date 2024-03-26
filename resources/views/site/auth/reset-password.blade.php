<div id="resetPasswordPage">
    <h5 class="mb-4">{{ __('auth.modal.password_reset.title') }}</h5>
    <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm" novalidate>
        @csrf

        <input type="hidden" name="token" value="{{ $new_password['change_pass_token'] }}">

        <div class="alert hidden" role="alert"></div>
        <div class="mb-4">
            <label for="resetPassEmailInput" class="form-label">{{ __('auth.modal.email') }}:</label>
            <input type="email" name="email" class="form-control" id="resetPassEmailInput" value="{{ $new_password['email'] }}" autocomplete="email">
            <div id="resetPassEmailInputFeedback" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="resetPasswordInput" class="form-label">{{ __('auth.modal.new_password') }}:</label>
            <input type="password" name="password" class="form-control" id="resetPasswordInput" autocomplete="new-password">
            <div id="resetPasswordInputFeedback" class="invalid-feedback"></div>
        </div>
        <div class="mb-4">
            <label for="confirmResetPasswordInput" class="form-label">{{ __('auth.modal.confirm_password') }}:</label>
            <input type="password" name="password_confirmation" class="form-control" id="confirmResetPasswordInput" autocomplete="new-password">
            <div id="confirmResetPasswordInputFeedback" class="invalid-feedback"></div>
        </div>
        <div class="preloader-btn-cont">
            <button type="submit">{{ __('auth.modal.password_reset.submit_btn') }}</button>
            <img class="preloader" src="{{ asset('img/preloader.gif') }}" alt="">
        </div>
    </form>
</div>