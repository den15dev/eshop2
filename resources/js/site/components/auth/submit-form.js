import { showAlert, clearAlert, clearValidationErrors, handleResponse } from "./handle-response.js";

const honPotHeader = 'pheeb4eKahxo';

export function submitForm(formElem, submitBtn) {
    showButtonPreloader(submitBtn);
    const formData = new FormData(formElem);

    fetch(formElem.action, {
        method: 'post',
        headers: {
            'Accept': 'application/json',
            honPotHeader
        },
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


function showButtonPreloader(buttonElem) {
    const preloader = buttonElem.parentNode.querySelector('.preloader');
    preloader.classList.remove('hidden');
}

function hideButtonPreloader(buttonElem) {
    const preloader = buttonElem.parentNode.querySelector('.preloader');
    preloader.classList.add('hidden');
}
