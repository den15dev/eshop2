import { translations } from "../common/global.js";
import '../common/effects/slide.js';
import { getCookieValue } from "../common/global.js";
import { showClientModal } from "../common/modals.js";
import { fadeIn, fadeOut } from "../common/effects/fade.js";

const popup = document.querySelector('.comparison-popup');
const compareBtns = document.querySelectorAll('.product-compare-btn');
const table = document.querySelector('.comparison-table');

const slideSpeed = 50;
const fadeSpeed = 300;
const cookieName = 'comparison';

let collapseBtn;
let collapseChevronIcon;
let popupBody;
let clearBtn;
let itemRemoveBtns;

let tableClearBtn;
let tableRemoveBtns;

let comparisonArr;

export default function init() {
    const comparisonCookie = getCookieValue(cookieName);
    comparisonArr = comparisonCookie ? JSON.parse(decodeURIComponent(comparisonCookie)) : null;

    initPopup();

    compareBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const product_id = btn.dataset.id;
            const category_id = btn.dataset.catid;
            updateList(product_id, category_id);
        });
    });

    if (table) {
        tableClearBtn = table.querySelector('.comparison-table_clear-btn');
        tableRemoveBtns = table.querySelectorAll('.comparison-table_remove-btn');

        tableRemoveBtns.forEach(removeBtn => {
            removeBtn.addEventListener('click', () => {
                const product_id = parseInt(removeBtn.dataset.id, 10);

                comparisonArr[1] = comparisonArr[1].filter(id => {
                    return id !== product_id;
                });

                if (comparisonArr[1].length > 0) {
                    setCookie(comparisonArr);
                } else {
                    removeCookie();
                }
                window.location.reload();
            });
        });

        tableClearBtn.addEventListener('click', () => {
            removeCookie();
            window.location.reload();
        });
    }
}


function initPopup() {
    let popupContent = document.querySelector('#comparisonContent');

    if (popupContent) {
        collapseBtn = popupContent.querySelector('.comparison-popup_head');
        collapseChevronIcon = collapseBtn.querySelector('.btn-icon > span');
        popupBody = popupContent.querySelector('.comparison-popup_body');
        clearBtn = popupBody.querySelector('#comparisonPopupClearBtn');
        itemRemoveBtns = popupBody.querySelectorAll('.comparison-popup_item > .btn-link');

        collapseBtn.addEventListener('click', () => {
            if (collapseBtn.dataset.collapsed === 'off') {
                popupBody.slideUp(slideSpeed, () => {
                    popup.classList.add('collapsed');
                });
                collapseChevronIcon.classList.replace('icon-chevron-down', 'icon-chevron-up');
                collapseBtn.dataset.collapsed = 'on';
                updateCookieCollapseState('on');
            } else {
                popup.classList.remove('collapsed');
                popupBody.slideDown(slideSpeed);
                collapseChevronIcon.classList.replace('icon-chevron-up', 'icon-chevron-down');
                collapseBtn.dataset.collapsed = 'off';
                updateCookieCollapseState('off');
            }
        });

        clearBtn.addEventListener('click', clearList);

        itemRemoveBtns.forEach(removeBtn => {
            removeBtn.addEventListener('click', () => {
                const product_id = removeBtn.closest('.comparison-popup_item').dataset.id;
                updateList(product_id, comparisonArr[0]);
            });
        });
    }
}


function updateList(product_id, category_id) {
    product_id = parseInt(product_id, 10);
    category_id = parseInt(category_id, 10);

    if (comparisonArr) {
        if (comparisonArr[0] === category_id) {

            if (comparisonArr[1].includes(product_id)) {
                comparisonArr[1] = comparisonArr[1].filter(id => {
                    return id !== product_id;
                });

                if (comparisonArr[1].length > 0) {
                    setCookie(comparisonArr);
                    getPopup();
                    makeButtonsInactive(product_id);
                } else {
                    clearList();
                }

            } else {
                comparisonArr[1].push(product_id);
                setCookie(comparisonArr);
                getPopup();
                makeButtonsActive(product_id);
            }

        } else {
            showClientModal({
                type: 'confirm',
                message: translations.comparison.modal.another_category,
                okText: translations.comparison.modal.proceed,
                okAction: function () {
                    setCookie([category_id, [product_id], 0]);
                    getPopup();
                    makeButtonsActive(product_id);
                },
            });
        }

    } else {
        setCookie([category_id, [product_id], 0]);
        getPopup(true);
        makeButtonsActive(product_id);
    }
}


function clearList() {
    removeCookie();

    popupBody.slideUp(slideSpeed, () => {
        fadeOut(popup, fadeSpeed, () => {
            window.location.reload();
        });
    });
}


function setCookie(newComparisonArr) {
    document.cookie = cookieName + '=' + encodeURIComponent(JSON.stringify(newComparisonArr)) + '; path=/;  max-age=157680000';
    comparisonArr = newComparisonArr;
}

function removeCookie() {
    document.cookie = cookieName + '=; path=/;  Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    comparisonArr = null;
}


function updateCookieCollapseState(state) {
    let comparisonArr = JSON.parse(decodeURIComponent(getCookieValue(cookieName)));
    comparisonArr[2] = state === 'on' ? 1 : 0;
    setCookie(comparisonArr);
}


function getPopup(firstShow = false) {
    fetch('/comparison/popup', {
        method: 'get',
    })
    .then(response => {
        if (!response.ok) throw new Error(`${response.status}`);
        return response.text();
    })
    .then(result => {
        popup.innerHTML = result;
        initPopup();
        if (firstShow) { showPopup(); }
    })
    .catch(err => {
        showClientModal({
            message: translations.general.messages.error_occurred,
            icon: 'warning',
        });
        console.error(err.message);
    });
}


function showPopup() {
    popupBody.style.display = 'none';

    fadeIn(popup, fadeSpeed, () => {
        popupBody.slideDown(slideSpeed);
    });
}


function makeButtonsActive(product_id) {
    const btns = document.querySelectorAll(`.product-compare-btn[data-id="${product_id}"]`);

    btns.forEach(btn => {
        btn.classList.add('active');

        const iconSpan = btn.querySelector('.compare-btn-icon');
        iconSpan.classList.replace('icon-bar-chart', 'icon-bar-chart-fill');

        const textSpan = btn.querySelector('.compare-btn-text');
        textSpan.innerText = translations.comparison.in_list;

        btn.title = translations.comparison.remove_title;
    });
}

function makeButtonsInactive(product_id) {
    const btns = document.querySelectorAll(`.product-compare-btn[data-id="${product_id}"]`);

    btns.forEach(btn => {
        btn.classList.remove('active');

        const iconSpan = btn.querySelector('.compare-btn-icon');
        iconSpan.classList.replace('icon-bar-chart-fill', 'icon-bar-chart');

        const textSpan = btn.querySelector('.compare-btn-text');
        textSpan.innerText = translations.comparison.compare;

        btn.removeAttribute('title');
    });
}

