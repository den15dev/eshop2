import { translations } from "../../common/global.js";
import {showModal, closeModal, showClientModal} from "../../common/modals.js";

const headerSignInBtn = document.querySelector('#headerSignInBtn');
const bnavSignInBtn = document.querySelector('#bnavSignInBtn');
const headerLogoutBtn = document.querySelector('#headerLogoutBtn');
const bnavLogoutBtn = document.querySelector('#bnavLogoutBtn');

const authModal = document.querySelector('#authModal');

const authMainPage = authModal ? document.querySelector('#authMainPage') : undefined;
const forgotPasswordPage = authModal ? document.querySelector('#forgotPasswordPage') : undefined;
const resetPasswordPage = authModal ? document.querySelector('#resetPasswordPage') : undefined;
const successPage = authModal ? document.querySelector('#successPage') : undefined;

export default function init() {
    if (authMainPage) {
        initAuthModal();
    }

    if (headerSignInBtn) {
        headerSignInBtn.addEventListener('click', showAuthModal);
    }

    if (bnavSignInBtn) {
        bnavSignInBtn.addEventListener('click', showAuthModal);
    }

    if (headerLogoutBtn) {
        headerLogoutBtn.addEventListener('click', e => {
            logOut(headerLogoutBtn);
        });
    }

    if (bnavLogoutBtn) {
        bnavLogoutBtn.addEventListener('click', e => {
            logOut(bnavLogoutBtn);
        });
    }

    if (resetPasswordPage) {
        showResetPasswordModal();
    }

    // Show login page for /login URL
    if (authModal && authModal.dataset?.loginPage) {
        showAuthModal();
    }
}


function showAuthModal() {
    if (authModal) {
        // Show main page
        authMainPage.style.display = 'block';
        forgotPasswordPage.style.display = 'none';
        successPage.style.display = 'none';

        showModal(authModal);
    }
}


function initAuthModal() {
    const forgotPasswordBtn = document.querySelector('#forgotPasswordBtn');
    const backToMainBtn = document.querySelector('#authMainBtn');

    forgotPasswordBtn.addEventListener('click', () => {
        authMainPage.style.display = 'none';
        forgotPasswordPage.style.display = 'block';
    });

    backToMainBtn.addEventListener('click', () => {
        forgotPasswordPage.style.display = 'none';
        authMainPage.style.display = 'block';
    });

    // Sign In (Login) form
    const loginForm = authMainPage.querySelector('form#signInTabPane');
    const loginSubmitBtn = loginForm.querySelector('button[type="submit"]');

    loginSubmitBtn.addEventListener('click', e => {
        e.preventDefault();
        submitForm(loginForm, loginSubmitBtn);
    });

    // Register form
    const registerForm = authMainPage.querySelector('form#registerTabPane');
    const registerSubmitBtn = registerForm.querySelector('button[type="submit"]');

    registerSubmitBtn.addEventListener('click', e => {
        e.preventDefault();
        submitForm(registerForm, registerSubmitBtn);
    });

    // Form for sending a password reset link
    const sendLinkForm = forgotPasswordPage.querySelector('form#sendResetLinkForm');
    const sendSubmitBtn = sendLinkForm.querySelector('button[type="submit"]');

    sendSubmitBtn.addEventListener('click', e => {
        e.preventDefault();
        submitForm(sendLinkForm, sendSubmitBtn);
    });

    // On inputs blur, if the input is empty, clear an error message.
    clearErrorOnEmptyInputBlur(authModal);
}


function showSuccessPage(message, onCloseAction = '') {
    authMainPage.style.display = 'none';
    forgotPasswordPage.style.display = 'none';
    if (resetPasswordPage) { resetPasswordPage.style.display = 'none'; }
    successPage.style.display = 'block';

    const messageCont = successPage.querySelector('p');
    messageCont.innerHTML = message;

    const okBtn = successPage.querySelector('button');
    okBtn.addEventListener('click', () => {
        closeModal(authModal);
        runOnClose(onCloseAction);
    });

    if (onCloseAction.length > 0) {
        const closeBtn = authModal.querySelector('.modal-close-btn');
        closeBtn.addEventListener('click', () => {
            runOnClose(onCloseAction);
        });
    }
}

function runOnClose(onCloseAction) {
    if (onCloseAction === 'reload') {
        window.location.reload();
    } else if (onCloseAction === 'home') {
        location.replace(new URL(location.href).origin);
    }
}


function showResetPasswordModal() {
    authMainPage.style.display = 'none';
    showModal(authModal);

    const resetPasswordForm = resetPasswordPage.querySelector('form#resetPasswordForm');
    const resetPasswordSubmitBtn = resetPasswordForm.querySelector('button[type="submit"]');

    resetPasswordSubmitBtn.addEventListener('click', e => {
        e.preventDefault();
        submitForm(resetPasswordForm, resetPasswordSubmitBtn);
    });
}


function submitForm(formElem, submitBtn) {
    showButtonPreloader(submitBtn);
    const formData = new FormData(formElem);

    fetch(formElem.action, {
        method: 'post',
        headers: { 'Accept': 'application/json' },
        body: new URLSearchParams(formData),
    })
    .then(response => {
        if (!response.ok && response.status !== 422) throw new Error(`${response.status}`);
        return response.json();
    })
    .then(result => {
        hideButtonPreloader(submitBtn);
        clearAlert(formElem);
        clearValidationErrors(formElem);
        handleResponse(result, formElem, formData);
    })
    .catch(err => {
        hideButtonPreloader(submitBtn);
        showAlert(formElem, 'warning', err.message);
    });
}


function handleResponse(jsonResult, formElem, formData) {
    if (jsonResult.errors) {
        showValidationErrors(formElem, formData, jsonResult);
        if (jsonResult.errors.alert) {
            showAlert(formElem, 'warning', jsonResult.errors.alert, false)
        }

    } else if (jsonResult.alert) {
        showAlert(formElem, 'warning', jsonResult.alert, false)

    } else if (jsonResult.status === 'logged') {
        closeModal(authModal);
        window.location.reload();

    } else if (jsonResult.status === 'registered') {
        const successMessage = `${jsonResult.message.welcome}<br>${jsonResult.message.link_sent}`;
        showSuccessPage(successMessage, 'reload');

    } else if (jsonResult.status === 'link_sent') {
        showSuccessPage(jsonResult.message);

    } else if (jsonResult.status === 'password_updated') {
        showSuccessPage(jsonResult.message, 'home');
    }
}


function showButtonPreloader(buttonElem) {
    const preloader = buttonElem.parentNode.querySelector('.preloader');
    preloader.style.display = 'block';
}


function hideButtonPreloader(buttonElem) {
    const preloader = buttonElem.parentNode.querySelector('.preloader');
    preloader.style.display = 'none';
}


function showValidationErrors(formElem, formData, jsonResponse) {
    for (const [input, value] of formData.entries()) {
        const inputElem = formElem[input];
        const feedbackCont = inputElem.parentNode.querySelector('.invalid-feedback');

        if (jsonResponse.errors[input]) {
            const errorMessage = jsonResponse.errors[input][0];
            inputElem.classList.add('is-invalid');
            feedbackCont.innerText = errorMessage;
        }
    }
}

function clearValidationErrors(formElem) {
    const inputElems = formElem.querySelectorAll('input');
    inputElems.forEach(input => input.classList.remove('is-invalid'));

    const feedbackConts = formElem.querySelectorAll('.invalid-feedback');
    feedbackConts.forEach(fbCont => fbCont.innerText = '');
}


/**
 * On inputs blur, if the input is empty, clear an error message.
 * @param modal
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

/**
 *
 * @param formElem
 * @param message
 * @param type — one of 'danger', 'warning', 'info', 'success', 'light', etc.
 * @param errorPrefix — if true, the prefix 'Error' in particular language
 * will be used. Used with unknown http-status codes, e.g. 'Error 404'.
 */
function showAlert(formElem, type, message, errorPrefix = true) {
    const alertCont = formElem.querySelector('.alert');
    if (alertCont) {
        alertCont.classList.add(`alert-${type}`);
        let content = message;
        if (errorPrefix) {
            content = `${translations.general.messages.error} ${message}`;
        }
        alertCont.innerText = content;
        alertCont.classList.remove('hidden');
    }
}

function clearAlert(formElem) {
    const alertCont = formElem.querySelector('.alert');
    if (alertCont) {
        alertCont.classList.remove(...alertCont.classList);
        alertCont.classList.add('alert');
        alertCont.innerText = '';
        alertCont.classList.add('hidden');
    }
}


function logOut(logoutBtn) {
    const formElem = logoutBtn.parentNode;
    const formData = new FormData(formElem);

    fetch(formElem.action, {
        method: 'post',
        headers: { 'Accept': 'application/json' },
        body: new URLSearchParams(formData),
    })
    .then(response => {
        if (!response.ok && response.status !== 422) throw new Error(`${response.status}`);
        return response.json();
    })
    .then(result => {
        if (result.status === 'logout') {
            window.location.reload();
        }
    })
    .catch(err => {
        showClientModal({
            message: `${translations.general.messages.error} ${err.message}`,
            icon: 'warning',
        });
    });
}


export function handlePasswordEyeBtns() {
    const eyeBtns = document.querySelectorAll('.password-eye_show');

    eyeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const inputs = btn.closest('form').querySelectorAll('input[name*="password"]');

            if (btn.classList.contains('password-eye_show')) {
                inputs.forEach((input, index) => {
                    input.type = 'text';
                    btn.classList.replace('password-eye_show', 'password-eye_hide');
                    if (!index) {
                        input.focus();
                    }
                });
            } else {
                inputs.forEach((input, index) => {
                    input.type = 'password';
                    btn.classList.replace('password-eye_hide', 'password-eye_show');
                    if (!index) {
                        input.focus();
                    }
                });
            }
        });
    });
}