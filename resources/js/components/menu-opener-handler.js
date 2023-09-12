import $ from 'jquery';
import { pageTint, fadeSpeed, htmlElem, lgMedia } from './_globals';
import { menuOpeners as openers } from './menu-openers';


export default function init() {
    openers.forEach(opener => {
        const btnArray = Array.isArray(opener.button) ? opener.button : [opener.button];
        btnArray.forEach((btn) => {
            btn.on('click', function() {
                toggleMenuOpener(opener);
            });
        });

        if (opener.closeButton) {
            opener.closeButton.on('click', function() {
                toggleMenuOpener(opener);
            });
        }
    });

    // Close all mobile menus on screen change to desktop
    lgMedia.addEventListener('change', () => {
        if (lgMedia.matches) {
            openers.forEach(opener => {
                if (opener.isOpened) {
                    closeOpener(opener);
                    $(pageTint).fadeOut(fadeSpeed);
                }
            });
        }
    });
}

function toggleMenuOpener(opener) {
    if (opener.isOpened) {
        closeOpener(opener);
        $(pageTint).fadeOut(fadeSpeed);
        enableScroll();
        $(document).off('click', closeOnClickOutside);

    } else {
        openers.forEach(prevOpener => {
            if (prevOpener.isOpened) {
                closeOpener(prevOpener);
            }
        })

        $(pageTint).fadeIn(fadeSpeed);
        opener.container.fadeIn(fadeSpeed);
        opener.openActions();
        opener.isOpened = true;
        disableScroll();
        $(document).on('click', closeOnClickOutside);
    }
}

function closeOpener(opener) {
    opener.container.fadeOut(fadeSpeed);
    opener.closeActions();
    opener.isOpened = false;
}

function closeOnClickOutside(event) {
    openers.forEach(opener => {
        if (opener.isOpened) {
            let elemArr = [opener.container];
            Array.isArray(opener.button) ? opener.button.forEach(elem => elemArr.push(elem)) : elemArr.push(opener.button);

            let parents = false;
            elemArr.forEach(elem => {
                if (!parents && $(event.target).closest($(elem)).length) {
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
    if (!lgMedia.matches && $(document).height() > $(window).height()) {
        $(htmlElem).addClass('noscroll-mobile');
    }
}

function enableScroll() {
    $(htmlElem).removeClass('noscroll-mobile');
    $(htmlElem).removeAttr('class');
}
