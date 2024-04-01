import { authMainCont, authModal, forgotPasswordCont, resetPasswordCont, successCont } from "./_constants.js";
import { closeModal, showModal } from "../../../common/modals.js";
import { submitForm } from "./submit-form.js";


export function showAuthWin() {
    if (authModal) {
        // Show main page
        authMainCont.style.display = 'block';
        forgotPasswordCont.style.display = 'none';
        successCont.style.display = 'none';

        showModal(authModal);
    }
}


export function showSuccessWin(message, onCloseAction = '') {
    authMainCont.style.display = 'none';
    forgotPasswordCont.style.display = 'none';
    if (resetPasswordCont) { resetPasswordCont.style.display = 'none'; }
    successCont.style.display = 'block';

    const messageCont = successCont.querySelector('p');
    messageCont.innerHTML = message;

    const okBtn = successCont.querySelector('button');
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


export function showResetPasswordWin() {
    authMainCont.style.display = 'none';
    showModal(authModal);

    const resetPasswordForm = resetPasswordCont.querySelector('form#resetPasswordForm');
    const resetPasswordSubmitBtn = resetPasswordForm.querySelector('button[type="submit"]');

    resetPasswordSubmitBtn.addEventListener('click', e => {
        e.preventDefault();
        submitForm(resetPasswordForm, resetPasswordSubmitBtn);
    });
}