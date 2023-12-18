<form class="tab-pane" action="{{ route('register') }}" method="POST" id="registerTabPane" novalidate>
    @csrf
    <div class="alert alert-danger" data-error-prefix="{{ __('auth.modal.error') }}" role="alert"></div>
    <div class="mb-3">
        <label for="registerNameInput" class="form-label">{{ __('auth.modal.name') }}:</label>
        <input type="text" name="name" class="form-control" id="registerNameInput" autocomplete="given-name">
        <div id="registerNameInputFeedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="registerEmailInput" class="form-label">{{ __('auth.modal.email') }}:</label>
        <input type="email" name="email" class="form-control" id="registerEmailInput" placeholder="name@example.com" autocomplete="email">
        <div id="registerEmailInputFeedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="registerPasswordInput" class="form-label">{{ __('auth.modal.password') }}:</label>
        <input type="password" name="password" class="form-control" id="registerPasswordInput" autocomplete="new-password">
        <div id="registerPasswordInputFeedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-4">
        <label for="registerConfirmPasswordInput" class="form-label">{{ __('auth.modal.confirm_password') }}:</label>
        <input type="password" name="password_confirmation" class="form-control" id="registerConfirmPasswordInput" autocomplete="new-password">
        <div id="registerConfirmPasswordInputFeedback" class="invalid-feedback"></div>
    </div>
    <div class="preloader-btn-cont">
        <button type="submit">{{ __('auth.modal.register') }}</button>
        <img class="preloader" src="{{ asset('img/preloader.gif') }}" alt="">
    </div>
</form>