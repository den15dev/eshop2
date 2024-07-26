import { tableName, searchParams } from "../components/index-table.js";
import { getTable } from "../components/index-table.js";


export default function init() {
    if (tableName === 'products') {
        initCategorySelect();
    }
}


function initCategorySelect() {
    const categorySelect = document.querySelector('.product-index_category select');

    categorySelect.addEventListener('change', () => {
        if (categorySelect.value) {
            searchParams.set('category', categorySelect.value);

        } else if (searchParams.has('category')) {
            searchParams.delete('category');
        }

        searchParams.delete('page');
        getTable();
    });
}
