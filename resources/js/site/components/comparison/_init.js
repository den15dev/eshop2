import { compareBtns, popup, popupBody, setPopupBody, slideSpeed } from "./_constants.js";
import { getComparisonArray, updateCookieCollapseState } from "./manage-cookie.js";
import { clearList, updateList } from "./update-list.js";


export default function init() {
    initPopup();

    compareBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const product_id = btn.dataset.id;
            const category_id = btn.dataset.catid;
            updateList(product_id, category_id);
        });
    });
}


export function initPopup() {
    let popupContent = document.querySelector('#comparisonContent');

    if (popupContent) {
        const collapseBtn = popupContent.querySelector('.comparison-popup_head');
        const collapseChevronIcon = collapseBtn.querySelector('.btn-icon > span');
        setPopupBody(popupContent.querySelector('.comparison-popup_body'));
        const clearBtn = popupBody.querySelector('#comparisonPopupClearBtn');
        const itemRemoveBtns = popupBody.querySelectorAll('.comparison-popup_item > .btn-link');

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
                const comparisonArr = getComparisonArray();
                updateList(product_id, comparisonArr[0]);
            });
        });
    }
}