import { closeDropdown } from "../../common/dropdowns.js";
import { getCookieValue } from "../../common/global.js";

const catalogPrefsCont = document.querySelector('.catalog-settings-cont');

const cookieName = 'catalog_prefs';
let prefsArr;


export default function init() {
    const prefsCookie = getCookieValue(cookieName);
    prefsArr = prefsCookie ? JSON.parse(decodeURIComponent(prefsCookie)) : ['new', 12, 1];

    if (catalogPrefsCont) {
        handleDropdown('sort-cont', 'sort', 0);
        handleDropdown('layout-cont', 'per_page', 1);
        handleLayoutButtons();
    }
}


function handleDropdown(contClassName, inputName, index) {
    const btns = document.querySelectorAll(`.catalog-settings-cont .${contClassName} .dropdown-item`);

    btns.forEach(btnElem => {
        btnElem.addEventListener('click', () => {
            if (btnElem.classList.contains('active')) {
                const dropdownBtn = btnElem.closest(`.${contClassName}`).querySelector('.dropdown-btn');
                closeDropdown(dropdownBtn);
            } else {
                prefsArr[index] = btnElem.dataset[inputName] ?? btnElem.innerText;
                setCookie(prefsArr);
                window.location.reload();
            }
        });
    });
}


function handleLayoutButtons() {
    const layoutBtns = document.querySelectorAll('.catalog-settings-cont .layout-cont > .btn-icon');

    layoutBtns.forEach((btnElem, index) => {
        if (!btnElem.classList.contains('active')) {
            btnElem.addEventListener('click', () => {
                prefsArr[2] = index + 1;
                setCookie(prefsArr);
                window.location.reload();
            });
        }
    });
}


function setCookie(prefsArr) {
    document.cookie = cookieName + '=' + encodeURIComponent(JSON.stringify(prefsArr)) + '; path=/;  max-age=157680000';
}