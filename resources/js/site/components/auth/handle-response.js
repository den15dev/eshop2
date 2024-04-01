import { closeModal } from "../../../common/modals.js";
import { translations } from "../../../common/global.js";
import { authModal } from "./_constants.js";
import { showSuccessWin } from "./show-window.js";


export function handleResponse(jsonResult, formElem, formData) {
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
        showSuccessWin(successMessage, 'reload');

    } else if (jsonResult.status === 'link_sent') {
        showSuccessWin(jsonResult.message);

    } else if (jsonResult.status === 'password_updated') {
        showSuccessWin(jsonResult.message, 'home');
    }
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

export function clearValidationErrors(formElem) {
    const inputElems = formElem.querySelectorAll('input');
    inputElems.forEach(input => input.classList.remove('is-invalid'));

    const feedbackConts = formElem.querySelectorAll('.invalid-feedback');
    feedbackConts.forEach(fbCont => fbCont.innerText = '');
}


/**
 * @param formElem
 * @param message
 * @param type — one of 'danger', 'warning', 'info', 'success', 'light', etc.
 * @param errorPrefix — if true, the prefix 'Error' in particular language
 * will be used. Used with unknown http-status codes, e.g. 'Error 404'.
 */
export function showAlert(formElem, type, message, errorPrefix = true) {
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

export function clearAlert(formElem) {
    const alertCont = formElem.querySelector('.alert');
    if (alertCont) {
        alertCont.classList.remove(...alertCont.classList);
        alertCont.classList.add('alert');
        alertCont.innerText = '';
        alertCont.classList.add('hidden');
    }
}