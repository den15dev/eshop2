import { fadeSpeed } from './global.js';
import { fadeIn, fadeOut } from "./effects/fade.js";

export default function init() {
    const closeBtns = document.querySelectorAll('.modal-close-btn');

    closeBtns.forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            const modal = closeBtn.closest('.modal-win');
            closeModal(modal);
        });
    });

    const flashOkBtn = document.querySelector('#flashOkBtn');

    flashOkBtn?.addEventListener('click', () => {
        const modal = flashOkBtn.closest('.modal-win');
        closeModal(modal);
    });
}


export function closeModal(modalElem) {
    const tint = modalElem.parentNode.querySelector('.modal-tint');
    fadeOut(modalElem, fadeSpeed);
    fadeOut(tint, fadeSpeed);
}

export function showModal(modalElem) {
    const tint = modalElem.parentNode.querySelector('.modal-tint');
    fadeIn(tint, fadeSpeed);
    fadeIn(modalElem, fadeSpeed);
}