import { getComparisonArray, removeCookie, setCookie } from "../components/comparison/manage-cookie.js";

const table = document.querySelector('.comparison-table');


export default function init() {
    if (table) {
        const tableClearBtn = table.querySelector('.comparison-table_clear-btn');
        const tableRemoveBtns = table.querySelectorAll('.comparison-table_remove-btn');
        let comparisonArr = getComparisonArray();

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