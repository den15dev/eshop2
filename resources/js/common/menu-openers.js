import { fadeSpeed, getMobileWinHeight } from './_globals';
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
        }
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
        }
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
        }
    },

    {
        button: '#bottomNavMenuBtn',
        container: '#bottomNavMenuCont',
        openActions() {
            document.querySelector(this.button).classList.add('active');
        },
        closeActions() {
            document.querySelector(this.button).classList.remove('active');
        }
    },

    {
        button: '#bottomNavFiltersBtn',
        container: '#bottomNavFiltersCont',
        openActions() {
            document.querySelector(this.button).classList.add('active');
            document.querySelector(this.container).style.height = `${getMobileWinHeight()}px`;
        },
        closeActions() {
            document.querySelector(this.button).classList.remove('active');
        },
        disablePageTint: true
    },

    {
        button: '#bottomNavProfileBtn',
        container: '#bottomNavProfileCont',
        openActions() {
            document.querySelector(this.button).classList.add('active');
        },
        closeActions() {
            document.querySelector(this.button).classList.remove('active');
        }
    }
];
