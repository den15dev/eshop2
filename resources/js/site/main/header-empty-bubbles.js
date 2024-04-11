import {fadeIn, fadeOut} from "../../common/effects/fade.js";

const userMenuBtns = document.querySelectorAll('#desktopHeader .nav-list-user > li > a');
const headerBubbles = document.querySelectorAll('.header-bubble');
const fadeSpeed = 200;
export let headerEmptyBubbleTimeout;


export default function init() {
    userMenuBtns.forEach(btn => {
        const badge = btn.querySelector('[class^="badge-round"]');
        if (badge) {
            btn.addEventListener('click', e => {

                const num = parseInt(badge.innerText, 10);
                if (!num) {
                    const bubble = badge.closest('li').querySelector('.header-bubble.empty');
                    if (bubble) {
                        e.preventDefault();
                        // Hide other bubbles
                        headerBubbles.forEach(otherBubble => {
                            if (isDisplayed(otherBubble)) {
                                fadeOut(otherBubble, fadeSpeed);
                            }
                        });

                        fadeIn(bubble, fadeSpeed);

                        clearTimeout(headerEmptyBubbleTimeout);
                        headerEmptyBubbleTimeout = setTimeout(() => {
                            fadeOut(bubble, fadeSpeed * 2);
                        }, 2000);
                    }
                }

            });
        }
    });
}


function isDisplayed(element) {
    return getComputedStyle(element).getPropertyValue('display') !== 'none';
}