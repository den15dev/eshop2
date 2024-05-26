import { fadeSpeed, translations } from './global.js';
import { fadeIn, fadeOut } from "./effects/fade.js";

const tint = document.querySelector('.modal-tint');
const flashModal = document.querySelector('#flashModal');

const clientModal = document.querySelector('#clientModal');
const okBtn = clientModal.querySelector('#clientOkBtn');
const cancelBtn = clientModal.querySelector('#clientCancelBtn');


export default function init() {
    const closeBtns = document.querySelectorAll('.modal-close-btn');

    closeBtns.forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            const modal = closeBtn.closest('.modal-win');
            closeModal(modal);
        });
    });

    if (okBtn) {
        okBtn.addEventListener('click', () => {
            closeModal(clientModal);
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            closeModal(clientModal);
        });
    }

    if (flashModal) {
        showFlashModal();
    }
}


export function closeModal(modalElem) {
    fadeOut(modalElem, fadeSpeed, () => hideModalContainer(modalElem));
    fadeOut(tint, fadeSpeed);
}


export function showModal(modalElem) {
    showModalContainer(modalElem);
    fadeIn(tint, fadeSpeed);
    fadeIn(modalElem, fadeSpeed);
}


function showFlashModal() {
    showModalContainer(flashModal);

    tint.style.display = 'block';
    flashModal.style.display = 'block';

    const flashOkBtn = document.querySelector('#flashOkBtn');

    flashOkBtn.addEventListener('click', () => {
        const modal = flashOkBtn.closest('.modal-win');
        closeModal(modal);
    });
}


function showModalContainer(modalElem) {
    const modalFlexCont = modalElem.parentNode;
    modalFlexCont.style.display = 'flex';
}

function hideModalContainer(modalElem) {
    const modalFlexCont = modalElem.parentNode;
    modalFlexCont.style.display = 'none';
}


/**
 * Shows a message window.
 *
 * @param data - {
 *     'type' - one of 'note' (default), or 'confirm';
 *     'icon' - one of 'info' (default), 'success', 'warning' or 'confirm';
 *     'message' - text or html message;
 *     'okAction' - a callback for an 'ok' button;
 *     'okText' - text for 'ok' button (default is 'ok');
 *     'cancelText' - text for 'Cancel' button (default is 'Cancel');
 * }
 */
export function showClientModal(data = {}) {
    const infoIcon = clientModal.querySelector('.modal-icon.info');
    const successIcon = clientModal.querySelector('.modal-icon.success');
    const warningIcon = clientModal.querySelector('.modal-icon.warning');
    const confirmIcon = clientModal.querySelector('.modal-icon.confirm');

    if (data.message) {
        const messageCont = clientModal.querySelector('p');
        messageCont.innerHTML = data.message;
    }

    if (data.type === 'confirm') {
        cancelBtn.style.display = 'block';

        if (data.cancelText) {
            cancelBtn.innerText = data.cancelText;
        }
    }

    if (data.okAction) {
        okBtn.addEventListener('click', data.okAction);

        okBtn.addEventListener('click', () => {
            okBtn.removeEventListener('click', data.okAction);
        });

        cancelBtn?.addEventListener('click', () => {
            okBtn.removeEventListener('click', data.okAction);
        });

        const closeBtn = okBtn.closest('.modal-win').querySelector('.modal-close-btn');
        closeBtn?.addEventListener('click', () => {
            okBtn.removeEventListener('click', data.okAction);
        });
    }

    if (data.okText) {
        okBtn.innerText = data.okText;
    }

    if (data.icon === 'success') {
        successIcon.style.display = 'block';
    } else if (data.icon === 'warning') {
        warningIcon.style.display = 'block';
    } else if (data.icon === 'confirm') {
        confirmIcon.style.display = 'block';
    } else {
        infoIcon.style.display = 'block';
    }

    showModal(clientModal);
}


export function showErrorMessage(error) {
    let message;
    let icon;

    switch (error.status) {
        case 403:
            message = translations.general.messages.forbidden;
            icon = 'info';
            break;
        default:
            message = translations.general.messages.error_occurred;
            icon = 'warning';
            break;
    }

    showClientModal({
        message: message,
        icon: icon,
    });

    console.error(`${error.status} (${error.statusText})`);
}