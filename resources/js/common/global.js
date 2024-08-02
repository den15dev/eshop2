import {showClientModal} from "./modals.js";

export const pageTint = document.querySelector('.page-tint');
export const fadeSpeed = 200;
export const htmlElem = document.querySelector('html');
export const lgMedia = window.matchMedia('(min-width: 992px)');
export const smMedia = window.matchMedia('(min-width: 576px)');

export const csrf = document.querySelector('meta[name="csrf-token"]').content;
export const lang = document.documentElement.lang;
export const submit403Messages = document.querySelector('meta[name="submit-403-messages"]')?.content;

export let translations;


export function getMobileWinHeight() {
    let bottomNavContHeight = document.querySelector('.bottom-nav_cont')?.offsetHeight || 0;
    let mobileHeaderHeight = document.querySelector('#mobileHeader')?.offsetHeight || 0;

    return window.innerHeight - mobileHeaderHeight - bottomNavContHeight;
}


export function getCookieValue(a, b, c) {
    b = '; ' + document.cookie;
    c = b.split('; ' + a + '=');
    return !!(c.length - 1) ? c.pop().split(';').shift() : '';
}


export function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}


export function setTimezoneCookie() {
    const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    if (getCookieValue('tz') !== tz) {
        document.cookie = 'tz=' + tz + '; path=/; max-age=2592000';
    }
}


export function getSiteTranslations() {
    fetch('/translations', {
        method: 'get',
        headers: { 'Accept': 'application/json' },
    })
    .then(response => {
        if (!response.ok) throw new Error(`${response.status}`);
        return response.json();
    })
    .then(result => {
        translations = result;
    })
    .catch(err => {
        console.error('An error occurred while getting translations: ' + err.message);
    });
}


export function getAdminTranslations() {
    fetch('/admin/translations', {
        method: 'get',
        headers: { 'Accept': 'application/json' },
    })
    .then(response => {
        if (!response.ok) throw new Error(`${response.status}`);
        return response.json();
    })
    .then(result => {
        translations = result;
    })
    .catch(err => {
        console.error('An error occurred while getting translations: ' + err.message);
    });
}


/**
 * Set minimum height for all textarea elements
 * and automatically adjust their height during typing
 * inside them to avoid scrolling.
 * You can set "data-minlines" attribute to a textarea
 * and set minimum number of lines.
 */
export function adjustTextAreaHeights() {
    const lineHeight = 24; // for 16px font size
    const extraHeight = 14; // for 16px font size
    const minLinesDefault = 3;

    const textAreas = document.querySelectorAll('textarea');

    const adjust = textarea => {
        const minLines = textarea.dataset.minlines
            ? parseInt(textarea.dataset.minlines, 10)
            : minLinesDefault;
        const minHeight = (lineHeight * minLines) + extraHeight;

        textarea.style.overflow = 'hidden';
        textarea.style.height = minHeight + 'px';
        if (textarea.scrollHeight > minHeight) {
            textarea.style.height = textarea.scrollHeight + 'px';
        }
    };

    textAreas.forEach(textarea => {
        adjust(textarea);

        textarea.addEventListener('keyup', () => {
            adjust(textarea);
        });
    });
}


export function showSubmit403Messages() {
    if (submit403Messages) {
        const submitBtns = document.querySelectorAll('button[type="submit"]');

        submitBtns.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();

                showClientModal({
                    message: translations.general.messages.forbidden,
                });
            });
        });
    }
}