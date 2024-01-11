import { closeDropdown } from "../common/dropdowns.js";

const prefForm = document.querySelector('#catalogPrefForm');

export default function init() {
    if (prefForm) {
        handleDropdown('sort-cont', 'sort');
        handleDropdown('layout-cont', 'per_page');
        handleLayoutButtons();
    }
}


function handleDropdown(contClassName, inputName) {
    const btns = document.querySelectorAll(`.catalog-settings-cont .${contClassName} .dropdown-list div`);

    btns.forEach(btnElem => {
        btnElem.addEventListener('click', () => {
            if (btnElem.classList.contains('active')) {
                const dropdownBtn = btnElem.closest(`.${contClassName}`).querySelector('.dropdown-btn');
                closeDropdown(dropdownBtn);
            } else {
                prefForm[inputName].value = btnElem.dataset[inputName] ?? btnElem.innerText;
                prefForm.submit();
            }
        });
    });
}


function handleLayoutButtons() {
    const layoutBtns = document.querySelectorAll('.catalog-settings-cont .layout-cont > .btn-icon');

    layoutBtns.forEach((btnElem, index) => {
        if (!btnElem.classList.contains('active')) {
            btnElem.addEventListener('click', () => {
                prefForm.layout.value = index + 1;
                prefForm.submit();
            });
        }
    });
}