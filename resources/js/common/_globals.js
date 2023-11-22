export const pageTint = document.querySelector('.main-tint');
export const fadeSpeed = 200;
export const htmlElem = document.querySelector('html');
export const lgMedia = window.matchMedia('(min-width: 992px)');
export const smMedia = window.matchMedia('(min-width: 576px)');

export function getMobileWinHeight() {
    const bottomNavContHeight = document.querySelector('.bottom-nav_cont').offsetHeight;
    const mobileHeaderHeight = document.querySelector('#mobileHeader').offsetHeight;
    return window.innerHeight - mobileHeaderHeight - bottomNavContHeight;
}
