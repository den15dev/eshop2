import { authMainCont, authModal, forgotPasswordCont, resetPasswordCont } from "./_constants.js";
import { showAuthWin, showResetPasswordWin } from "./show-window.js";
import { submitForm } from "./submit-form.js";
import { handlePasswordEyeBtns } from "./utilities.js";
import { logOut } from "./logout.js";

export default function init() {
    initSignInButtons();
    initLogoutButtons();

    if (authMainCont) {
        initAuthWin();
    }

    if (resetPasswordCont) {
        showResetPasswordWin();
    }

    // Show login page for /login URL
    if (authModal && authModal.dataset?.loginPage) {
        showAuthWin();
    }

    handlePasswordEyeBtns();
}


function initSignInButtons() {
    const headerSignInBtn = document.querySelector('#headerSignInBtn');
    if (headerSignInBtn) {
        headerSignInBtn.addEventListener('click', showAuthWin);
    }

    const bnavSignInBtn = document.querySelector('#bnavSignInBtn');
    if (bnavSignInBtn) {
        bnavSignInBtn.addEventListener('click', showAuthWin);
    }
}


function initLogoutButtons() {
    const headerLogoutBtn = document.querySelector('#headerLogoutBtn');
    if (headerLogoutBtn) {
        headerLogoutBtn.addEventListener('click', () => {
            logOut(headerLogoutBtn);
        });
    }

    const bnavLogoutBtn = document.querySelector('#bnavLogoutBtn');
    if (bnavLogoutBtn) {
        bnavLogoutBtn.addEventListener('click', () => {
            logOut(bnavLogoutBtn);
        });
    }
}


function initAuthWin() {
    const forgotPasswordBtn = document.querySelector('#forgotPasswordBtn');
    const backToMainBtn = document.querySelector('#authMainBtn');

    forgotPasswordBtn.addEventListener('click', () => {
        authMainCont.style.display = 'none';
        forgotPasswordCont.style.display = 'block';
    });

    backToMainBtn.addEventListener('click', () => {
        forgotPasswordCont.style.display = 'none';
        authMainCont.style.display = 'block';
    });

    // Sign In (Login) form
    const loginForm = authMainCont.querySelector('form#signInTabPane');
    const loginSubmitBtn = loginForm.querySelector('button[type="submit"]');

    loginSubmitBtn.addEventListener('click', e => {
        e.preventDefault();
        submitForm(loginForm, loginSubmitBtn);
    });

    // Register form
    const registerForm = authMainCont.querySelector('form#registerTabPane');
    const registerSubmitBtn = registerForm.querySelector('button[type="submit"]');

    registerSubmitBtn.addEventListener('click', e => {
        e.preventDefault();
        submitForm(registerForm, registerSubmitBtn);
    });

    // Form for sending a password reset link
    const sendLinkForm = forgotPasswordCont.querySelector('form#sendResetLinkForm');
    const sendSubmitBtn = sendLinkForm.querySelector('button[type="submit"]');

    sendSubmitBtn.addEventListener('click', e => {
        e.preventDefault();
        submitForm(sendLinkForm, sendSubmitBtn);
    });

    clearErrorOnEmptyInputBlur(authModal);
}


/**
 * On inputs blur, if the input is empty, clear an error message.
 */
function clearErrorOnEmptyInputBlur(modal) {
    const inputs = modal.querySelectorAll('input');

    inputs.forEach(input => {
        input.addEventListener('blur', () => {
            if (input.value === '') {
                input.classList.remove('is-invalid');
                const feedbackCont = input.parentNode.querySelector('.invalid-feedback');
                if (feedbackCont) {
                    feedbackCont.innerText = '';
                }
            }
        });
    });
}