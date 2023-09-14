import { pageTint, fadeSpeed, htmlElem, lgMedia } from './_globals';
import { fadeIn, fadeOut } from "../effects/fade";
import { menuOpeners as openers } from './menu-openers';


export default function init() {
    openers.forEach(opener => {
        const btnArray = Array.isArray(opener.button) ? opener.button : [opener.button];
        btnArray.forEach((btn) => {
            document.querySelector(btn).addEventListener('click', function() {
                toggleMenuOpener(opener);
            });
        });

        if (opener.closeButton) {
            document.querySelector(opener.closeButton).addEventListener('click', function() {
                toggleMenuOpener(opener);
            });
        }
    });

    // Close all mobile menus on screen change to desktop
    lgMedia.addEventListener('change', () => {
        openers.forEach(opener => {
            if (opener.isOpened) {
                closeOpener(opener);
                fadeOut(pageTint, fadeSpeed);
                enableScroll();
            }
        });
    });
}

function toggleMenuOpener(opener) {
    if (opener.isOpened) {
        closeOpener(opener);
        fadeOut(pageTint, fadeSpeed);
        enableScroll();
        document.removeEventListener('click', closeOnClickOutside);

    } else {
        openers.forEach(prevOpener => {
            if (prevOpener.isOpened) {
                closeOpener(prevOpener);
            }
        })

        fadeIn(pageTint, fadeSpeed);
        fadeIn(document.querySelector(opener.container), fadeSpeed);
        opener.openActions();
        opener.isOpened = true;
        disableScroll();
        document.addEventListener('click', closeOnClickOutside);
    }
}

function closeOpener(opener) {
    fadeOut(document.querySelector(opener.container), fadeSpeed);
    opener.closeActions();
    opener.isOpened = false;
}

function closeOnClickOutside(event) {
    openers.forEach(opener => {
        if (opener.isOpened) {
            let selArr = [opener.container];
            Array.isArray(opener.button) ? opener.button.forEach(selector => selArr.push(selector)) : selArr.push(opener.button);

            let parents = false;
            selArr.forEach(selector => {
                if (!parents && event.target.closest(selector)) {
                    parents = true;
                }
            });

            if (!parents) {
                toggleMenuOpener(opener);
            }
        }
    });
}

function disableScroll() {
    if (!lgMedia.matches && document.body.scrollHeight > window.innerHeight) {
        htmlElem.classList.add('noscroll-mobile');
    }
}

function enableScroll() {
    htmlElem.classList.remove('noscroll-mobile');
    htmlElem.removeAttribute('class');
}