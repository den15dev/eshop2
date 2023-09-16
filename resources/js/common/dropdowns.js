import {fadeIn, fadeOut} from "../effects/fade";

const fadeSpeed = 200;
let dropdownOpened = false;

function openDropdown(dropdown_btn) {
    if (dropdownOpened) closeAllDropdowns();
    fadeIn(dropdown_btn.parentNode.querySelector('.dropdown-list'), fadeSpeed);
    dropdown_btn.dataset.opened = 'on';
    dropdownOpened = true;
    document.addEventListener('click', closeOnClickOutside);
}

function closeDropdown(dropdown_btn) {
    fadeOut(dropdown_btn.parentNode.querySelector('.dropdown-list'), fadeSpeed);
    dropdown_btn.dataset.opened = 'off';
    document.removeEventListener('click', closeOnClickOutside);
}

function closeAllDropdowns() {
    document.querySelectorAll('.dropdown-btn').forEach(btn => {
        if (btn.dataset.opened === 'on') {
            closeDropdown(btn);
        }
    });
    dropdownOpened = false;
}

function closeOnClickOutside(event) {
    if (dropdownOpened && !event.target.closest('.dropdown-btn, .dropdown-list')) {
        closeAllDropdowns();
    }
}

export default function init() {
    document.querySelectorAll('.dropdown-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.dataset.opened === 'on' ? closeAllDropdowns() : openDropdown(btn);
        });
    });
}

export function languageDropdown() {
    document.querySelectorAll('.lang-menu a').forEach(btn => {
        btn.addEventListener('click', () => {
            const checkIcon = btn.parentNode.parentNode.querySelector('.icon-check-lg');
            const checkIconClone = checkIcon.cloneNode();
            btn.appendChild(checkIconClone);
            checkIcon.remove();
        });
    });
}