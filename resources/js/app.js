import './bootstrap';

import menuOpeners  from './common/menu-opener-handler';
import dropdowns, { languageDropdown } from "./common/dropdowns";
import catalogMobile  from './common/catalog-mobile';
import { catalogDesktopRoot, catalogDesktopDropdowns } from "./common/catalog-desktop";
import search from './common/search';

// import { fadeIn, fadeOut, fadeToggle } from "../effects/fade";
// import '../effects/slide';

// ---------------------------------

menuOpeners();
dropdowns();
languageDropdown();
catalogMobile();
catalogDesktopRoot();
catalogDesktopDropdowns();
search();


// --- Fade test ---
/*
const testFadeBox = document.querySelector('#testFadeBox');
document.querySelector('#testFadeInBtn').addEventListener('click', (e) => {
    fadeIn(testFadeBox, 200);
    testFadeBox.dataset.displayed = 'on';
});
document.querySelector('#testFadeOutBtn').addEventListener('click', (e) => {
    fadeOut(testFadeBox, 200);
    testFadeBox.dataset.displayed = 'off';
});
document.querySelector('#testFadeToggleBtn').addEventListener('click', (e) => {
    fadeToggle(testFadeBox, 200);
});
*/
/*
console.log(getComputedStyle(document.querySelector('#catalogBtnDesktop .svg-catalog-list')).getPropertyValue('display'));
console.log(getComputedStyle(document.querySelector('#catalogBtnDesktop .svg-close')).getPropertyValue('display'));
console.log(getComputedStyle(document.querySelector('#catalogBtnDesktop .svg-close')).getPropertyValue('opacity'));
console.log(getComputedStyle(document.querySelector('.main-tint')).getPropertyValue('opacity'));
*/
/*
const testFadeBox = document.querySelector('#testFadeBox');
document.querySelector('#testFadeInBtn').addEventListener('click', (e) => {
    testFadeBox.slideToggle(200);
});
*/

// console.log(document.querySelectorAll('#catalogNavMobile .catalog-mobile-list > li').length);