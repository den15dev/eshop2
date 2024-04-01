import { showClientModal } from "../../../common/modals.js";
import { translations } from "../../../common/global.js";
import { fadeOut } from "../../../common/effects/fade.js";
import { toggleButtons } from "./toggle-buttons.js";
import { getComparisonArray, removeCookie, setCookie } from "./manage-cookie.js";
import { popup, popupBody, fadeSpeed, slideSpeed } from "./_constants.js";
import { getPopup } from "./get-popup.js";


export function updateList(product_id, category_id) {
    product_id = parseInt(product_id, 10);
    category_id = parseInt(category_id, 10);

    let comparisonArr = getComparisonArray();
    let firstShow = false;

    if (comparisonArr) {
        if (comparisonArr[0] === category_id) {

            if (comparisonArr[1].includes(product_id)) {
                comparisonArr[1] = comparisonArr[1].filter(id => {
                    return id !== product_id;
                });

                if (!comparisonArr[1].length) {
                    clearList();
                    return;
                }

            } else {
                comparisonArr[1].push(product_id);
            }

        } else {
            showClientModal({
                type: 'confirm',
                message: translations.comparison.modal.another_category,
                okText: translations.comparison.modal.proceed,
                okAction: function () {
                    comparisonArr = [category_id, [product_id], 0];
                    doUpdate(comparisonArr, firstShow, product_id);
                },
            });

            return;
        }

    } else {
        comparisonArr = [category_id, [product_id], 0];
        firstShow = true;
    }

    doUpdate(comparisonArr, firstShow, product_id);
}


function doUpdate(comparisonArr, firstShow, product_id) {
    setCookie(comparisonArr);
    getPopup(firstShow);
    toggleButtons(product_id);
}


export function clearList() {
    removeCookie();

    popupBody.slideUp(slideSpeed, () => {
        fadeOut(popup, fadeSpeed, () => {
            window.location.reload();
        });
    });
}