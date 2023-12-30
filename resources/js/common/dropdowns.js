import {fadeIn, fadeOut} from "./effects/fade";

const fadeSpeed = 100;
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

export function localizationDropdowns() {
    document.querySelectorAll('.local-menu').forEach(localDD => {
        const type = localDD.dataset.type;
        const typeCap = type.charAt(0).toUpperCase() + type.slice(1);
        const ddBtn = localDD.querySelector('.dropdown-btn');

        localDD.querySelectorAll('.dropdown-list div').forEach(divItem => {
            if (divItem.dataset.isCurrent) {
                divItem.addEventListener('click', () => {
                    closeDropdown(ddBtn);
                });
            } else {
                divItem.addEventListener('click', () => {
                    const id = divItem.dataset.itemId;
                    const formElem = document.querySelector(`#change${typeCap}Form`);
                    formElem.querySelector(`[name="new_${type}"]`).value = id;
                    formElem.submit();
                });
            }
        });
    });
}