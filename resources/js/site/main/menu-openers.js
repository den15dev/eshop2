import { fadeSpeed, getMobileWinHeight } from '../../common/global.js';
import { fadeIn, fadeOut } from "../../common/effects/fade.js";
import { catalogMobileReset } from './catalog-mobile.js';


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
            this.setFilterContHeight();
            window.addEventListener('resize', this.setFilterContHeight);
        },
        closeActions() {
            document.querySelector(this.button).classList.remove('active');
            window.removeEventListener('resize', this.setFilterContHeight);
        },
        setFilterContHeight() {
            document.querySelector('#bottomNavFiltersCont').style.height = `${getMobileWinHeight()}px`;
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
