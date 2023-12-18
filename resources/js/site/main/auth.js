import { showModal, closeModal } from "../../common/modals.js";

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
    }
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
        location.replace(location.href);
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
    .catch(err => showAlert(formElem, 'danger', err.message));
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
        location.replace(location.href);

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
 *
 * @param formElem
 * @param message
 * @param type — one of 'danger', 'warning', 'info', 'success', 'light', etc.
 * @param withPrefix — if true, the prefix 'Error' in particular language
 * will be used. Used with unknown http-status codes, e.g. 'Error 404'.
 */
function showAlert(formElem, type, message, withPrefix = true) {
    const alertCont = formElem.querySelector('.alert');
    if (alertCont) {
        alertCont.classList.add(`alert-${type}`);
        let content = message;
        if (withPrefix) {
            const errorPrefix = alertCont.dataset.errorPrefix;
            content = `${errorPrefix} ${message}`;
        }
        alertCont.innerText = content;
        alertCont.style.display = 'block';
    }
}

function clearAlert(formElem) {
    const alertCont = formElem.querySelector('.alert');
    if (alertCont) {
        alertCont.classList.remove(...alertCont.classList);
        alertCont.classList.add('alert');
        alertCont.innerText = '';
        alertCont.style.display = 'none';
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
            location.replace(location.href);
        }
    })
    .catch(err => {
        // Show modal
    });
}