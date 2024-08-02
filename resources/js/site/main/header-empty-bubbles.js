import {fadeIn, fadeOut} from "../../common/effects/fade.js";

const userMenuBtns = document.querySelectorAll('#desktopHeader .nav-list-user .outline-btn');
const headerBubbles = document.querySelectorAll('.header-bubble');
const fadeSpeed = 200;
export let headerEmptyBubbleTimeout;


export default function init() {
    userMenuBtns.forEach(menuBtn => {
        menuBtn.addEventListener('click', e => {
            const emptyBubble = menuBtn.parentNode.querySelector('.header-bubble.empty');

            if (emptyBubble?.dataset.active) {
                e.preventDefault();
                // Hide other bubbles
                headerBubbles.forEach(otherBubble => {
                    if (isDisplayed(otherBubble)) {
                        fadeOut(otherBubble, fadeSpeed);
                    }
                });

                fadeIn(emptyBubble, fadeSpeed);

                clearTimeout(headerEmptyBubbleTimeout);
                headerEmptyBubbleTimeout = setTimeout(() => {
                    fadeOut(emptyBubble, fadeSpeed * 2);
                }, 2000);
            }
        });
    });
}


function isDisplayed(element) {
    return getComputedStyle(element).getPropertyValue('display') !== 'none';
}