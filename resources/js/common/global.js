export const pageTint = document.querySelector('.page-tint');
export const fadeSpeed = 200;
export const htmlElem = document.querySelector('html');
export const lgMedia = window.matchMedia('(min-width: 992px)');
export const smMedia = window.matchMedia('(min-width: 576px)');

export function getMobileWinHeight() {
    let bottomNavContHeight = document.querySelector('.bottom-nav_cont')?.offsetHeight || 0;
    let mobileHeaderHeight = document.querySelector('#mobileHeader')?.offsetHeight || 0;

    return window.innerHeight - mobileHeaderHeight - bottomNavContHeight;
}
