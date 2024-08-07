<div id="forgotPasswordCont" style="display: none">
    <div class="link mb-25" style="margin-left: -4px" id="authMainBtn">
        <span class="icon-chevron-left small va1"></span>
        {{ __('auth.modal.back') }}
    </div>
    <p class="grey-text">{{ __('auth.modal.forgot_note') }}</p>
    <form method="POST" action="{{ route('password.email') }}" id="sendResetLinkForm" novalidate>
        @csrf
        <div class="alert hidden" role="alert"></div>
        <div class="mb-4">
            <label for="forgotPassEmailInput" class="form-label">{{ __('auth.modal.email') }}:</label>
            <input type="email" name="email" class="form-control" id="forgotPassEmailInput" placeholder="name@example.com" autocomplete="email">
            <div id="forgotPassEmailInputFeedback" class="invalid-feedback"></div>
        </div>
        <div class="preloader-cont">
            <button type="submit">{{ __('auth.modal.forgot_send') }}</button>
            <img class="preloader pl-btn hidden" src="{{ asset('img/preloader.gif') }}" alt="">
        </div>
    </form>
</div>