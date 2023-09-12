import $ from 'jquery';
import { fadeSpeed } from './_globals';
import { catalogMobileReset } from './catalog-mobile';


export const menuOpeners = [
    {
        button: [$('#catalogBtnDesktop'), $('#catalogBtnMobile')],
        container: $('#catalogNavCont'),
        openActions() {
            $('#catalogBtnDesktop .svg-catalog-list').fadeOut(fadeSpeed);
            $('#catalogBtnDesktop .svg-close').fadeIn(fadeSpeed);
            $('#catalogBtnMobile .svg-chevron-down').fadeOut(fadeSpeed);
            $('#catalogBtnMobile .svg-close').fadeIn(fadeSpeed);
        },
        closeActions() {
            $('#catalogBtnDesktop .svg-catalog-list').fadeIn(fadeSpeed);
            $('#catalogBtnDesktop .svg-close').fadeOut(fadeSpeed);
            $('#catalogBtnMobile .svg-chevron-down').fadeIn(fadeSpeed);
            $('#catalogBtnMobile .svg-close').fadeOut(fadeSpeed);
            catalogMobileReset();
        },
        closeButton: null,
        isOpened: false
    },

    {
        button: $('#searchBtnMobileNav'),
        container: $('#searchMobileCont'),
        openActions() {
            $('#searchBtnMobileNav .svg-search').fadeOut(fadeSpeed);
            $('#searchBtnMobileNav .svg-close').fadeIn(fadeSpeed);
            $('#searchInputMobile').focus();
        },
        closeActions() {
            $('#searchBtnMobileNav .svg-search').fadeIn(fadeSpeed);
            $('#searchBtnMobileNav .svg-close').fadeOut(fadeSpeed);
        },
        closeButton: null,
        isOpened: false
    },

    {
        button: $('#bottomNavMenuBtn'),
        container: $('#bottomNavMenuCont'),
        openActions() {
            $('#bottomNavMenuBtn').addClass('active');
        },
        closeActions() {
            $('#bottomNavMenuBtn').removeClass('active');
        },
        closeButton: $('#bottomMenuCloseBtn'),
        isOpened: false
    },

    {
        button: $('#bottomNavProfileBtn'),
        container: $('#bottomNavProfileCont'),
        openActions() {
            $('#bottomNavProfileBtn').addClass('active');
        },
        closeActions() {
            $('#bottomNavProfileBtn').removeClass('active');
        },
        closeButton: $('#bottomMenuProfileCloseBtn'),
        isOpened: false
    }
];
