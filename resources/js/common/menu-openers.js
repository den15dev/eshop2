import { fadeSpeed } from './_globals';
import { fadeIn, fadeOut } from "../effects/fade";
import { catalogMobileReset } from './catalog-mobile';


export const menuOpeners = [
    {
        button: '#catalogBtnDesktop',
        container: '#catalogNavCont',
        openActions() {
            fadeOut(document.querySelector('#catalogBtnDesktop .svg-catalog-list'), fadeSpeed);
            fadeIn(document.querySelector('#catalogBtnDesktop .svg-close'), fadeSpeed);
        },
        closeActions() {
            fadeIn(document.querySelector('#catalogBtnDesktop .svg-catalog-list'), fadeSpeed);
            fadeOut(document.querySelector('#catalogBtnDesktop .svg-close'), fadeSpeed);
        },
        closeButton: null,
        isOpened: false
    },

    {
        button: '#catalogBtnMobile',
        container: '#catalogNavCont',
        openActions() {
            fadeOut(document.querySelector('#catalogBtnMobile .svg-chevron-down'), fadeSpeed);
            fadeIn(document.querySelector('#catalogBtnMobile .svg-close'), fadeSpeed);
        },
        closeActions() {
            fadeIn(document.querySelector('#catalogBtnMobile .svg-chevron-down'), fadeSpeed);
            fadeOut(document.querySelector('#catalogBtnMobile .svg-close'), fadeSpeed);
            catalogMobileReset();
        },
        closeButton: null,
        isOpened: false
    },

    {
        button: '#searchBtnMobileNav',
        container: '#searchMobileCont',
        openActions() {
            fadeOut(document.querySelector('#searchBtnMobileNav .svg-search'), fadeSpeed);
            fadeIn(document.querySelector('#searchBtnMobileNav .svg-close'), fadeSpeed);
            document.querySelector('#searchInputMobile').focus();
        },
        closeActions() {
            fadeIn(document.querySelector('#searchBtnMobileNav .svg-search'), fadeSpeed);
            fadeOut(document.querySelector('#searchBtnMobileNav .svg-close'), fadeSpeed);
        },
        closeButton: null,
        isOpened: false
    },

    {
        button: '#bottomNavMenuBtn',
        container: '#bottomNavMenuCont',
        openActions() {
            document.querySelector('#bottomNavMenuBtn').classList.add('active');
        },
        closeActions() {
            document.querySelector('#bottomNavMenuBtn').classList.remove('active');
        },
        closeButton: '#bottomMenuCloseBtn',
        isOpened: false
    },

    {
        button: '#bottomNavProfileBtn',
        container: '#bottomNavProfileCont',
        openActions() {
            document.querySelector('#bottomNavProfileBtn').classList.add('active');
        },
        closeActions() {
            document.querySelector('#bottomNavProfileBtn').classList.remove('active');
        },
        closeButton: '#bottomMenuProfileCloseBtn',
        isOpened: false
    }
];
