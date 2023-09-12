import './bootstrap';
// import $ from 'jquery';
// window.$ = $;
// window.jQuery = $;

import menuOpeners  from './components/menu-opener-handler';
import dropdowns, { languageDropdown } from "./components/dropdowns";
import catalogMobile  from './components/catalog-mobile';
import { catalogDesktopRoot, catalogDesktopDropdowns } from "./components/catalog-desktop";
import search from './components/search';

import { fadeInit, fadeToggle2 } from "./components/effects";

// ---------------------------------

menuOpeners();
dropdowns();
languageDropdown();
catalogMobile();
catalogDesktopRoot();
catalogDesktopDropdowns();
search();

fadeInit();

// --- Fade test ---
const testFadeBox = document.querySelector('#testFadeBox');
document.querySelector('#testFadeBtn').addEventListener('click', (e) => {
    fadeToggle2(testFadeBox, 100);
});