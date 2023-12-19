import { fadeSpeed } from './global.js';
import { fadeIn, fadeOut } from "./effects/fade.js";

const tint = document.querySelector('.modal-tint');
let fadeTimeout;

export default function init() {
    const closeBtns = document.querySelectorAll('.modal-close-btn');

    closeBtns.forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            const modal = closeBtn.closest('.modal-win');
            closeModal(modal);
        });
    });

    showFlashModal();
}


export function closeModal(modalElem) {
    clearTimeout(fadeTimeout);
    fadeTimeout = setTimeout(() => {
        hideModalContainer(modalElem);
    }, fadeSpeed + 50);

    fadeOut(modalElem, fadeSpeed);
    fadeOut(tint, fadeSpeed);
}


export function showModal(modalElem) {
    showModalContainer(modalElem);
    fadeIn(tint, fadeSpeed);
    fadeIn(modalElem, fadeSpeed);
}


function showFlashModal() {
    const flashModal = document.querySelector('#flashModal');
    if (flashModal) {
        showModalContainer(flashModal);

        tint.style.display = 'block';
        flashModal.style.display = 'block';

        const flashOkBtn = document.querySelector('#flashOkBtn');

        flashOkBtn.addEventListener('click', () => {
            const modal = flashOkBtn.closest('.modal-win');
            closeModal(modal);
        });
    }
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
    const clientModal = document.querySelector('#clientModal');
    const okBtn = clientModal.querySelector('#clientOkBtn');
    const cancelBtn = clientModal.querySelector('#clientCancelBtn');

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
        cancelBtn.addEventListener('click', () => {
            closeModal(clientModal);
        });

        if (data.okAction) {
            okBtn.addEventListener('click', () => {
                closeModal(clientModal);
                data.okAction();
            });
        }

        if (data.cancelText) {
            cancelBtn.innerText = data.cancelText;
        }
    } else {
        okBtn.addEventListener('click', () => {
            closeModal(clientModal);
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