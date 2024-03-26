<form class="tab-pane active" action="{{ route('login.store') }}" method="POST" id="signInTabPane" novalidate>
    @csrf
    <div class="alert hidden" role="alert"></div>
    <div class="mb-3">
        <label for="signInEmailInput" class="form-label">{{ __('auth.modal.email') }}:</label>
        <input type="email" name="email" class="form-control" id="signInEmailInput" placeholder="name@example.com" autocomplete="email">
        <div id="signInEmailInputFeedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="signInPasswordInput" class="form-label">{{ __('auth.modal.password') }}:</label>
        <div class="password-eye_cont">
            <input type="password" name="password" class="form-control" id="signInPasswordInput" autocomplete="current-password">
            <div id="signInPasswordInputFeedback" class="invalid-feedback"></div>
            <div class="password-eye_show"></div>
        </div>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" name="remember" type="checkbox" role="switch" id="signInRememberCheck">
        <label class="form-check-label" for="signInRememberCheck">{{ __('auth.modal.remember') }}</label>
    </div>
    <div class="preloader-btn-cont mb-4">
        <button type="submit">{{ __('auth.modal.sign_in_button') }}</button>
        <img class="preloader" src="{{ asset('img/preloader.gif') }}" alt="">
    </div>
    <div class="link w-fit" role="button" id="forgotPasswordBtn">{{ __('auth.modal.forgot') }}</div>
</form>