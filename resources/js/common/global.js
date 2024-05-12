export const pageTint = document.querySelector('.page-tint');
export const fadeSpeed = 200;
export const htmlElem = document.querySelector('html');
export const lgMedia = window.matchMedia('(min-width: 992px)');
export const smMedia = window.matchMedia('(min-width: 576px)');

export const csrf = document.querySelector('meta[name="csrf-token"]').content;
export const lang = document.documentElement.lang;

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
