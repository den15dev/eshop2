import { showErrorMessage } from "../../../common/modals.js";
import { fadeSpeed, popup, popupBody, slideSpeed } from "./_constants.js";
import { initPopup } from "./_init.js";
import { fadeIn } from "../../../common/effects/fade.js";


export function getPopup(firstShow = false) {
    fetch('/comparison/popup', {
        method: 'get',
    })
    .then(response => {
        if (!response.ok) {
            const error = new Error();
            error.status = response.status;
            error.statusText = response.statusText;
            throw error;
        }
        return response.text();
    })
    .then(result => {
        popup.innerHTML = result;
        initPopup();
        if (firstShow) { showPopup(); }
    })
    .catch(err => showErrorMessage(err));
}


function showPopup() {
    popupBody.style.display = 'none';

    fadeIn(popup, fadeSpeed, () => {
        popupBody.slideDown(slideSpeed);
    });
}