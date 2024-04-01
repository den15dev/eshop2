<div class="modal-container">
    <div class="modal-win" {!! isset($is_login_page) && $is_login_page ? 'data-login-page="1"' : '' !!} id="authModal">
        <button class="btn-icon modal-close-btn">
            <span class="icon-x-lg"></span>
        </button>

        <div id="authMainCont">
            <nav class="tab-cont mb-4">
                <div class="tab-btn active" role="button" id="signInTab">
                    {{ __('auth.modal.sign_in') }}
                </div>
                <div class="tab-btn link" role="button" id="registerTab">
                    {{ __('auth.modal.registration') }}
                </div>
            </nav>

            @include('site.auth.login-form')

            @include('site.auth.register-form')
        </div>

        @include('site.auth.forgot-password')

        @if(isset($new_password))
            @include('site.auth.reset-password')
        @endif

        <div id="successCont" style="display: none">
            <p class="mt-3 mb-45 text-center"></p>
            <button class="mx-auto">Ok</button>
        </div>
    </div>
</div>