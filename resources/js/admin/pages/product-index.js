import { tableName, searchParams } from "../components/index-table.js";
import { getTable } from "../components/index-table.js";


export default function init() {
    if (tableName === 'products') {
        initCategorySelect();
        initCheckboxes();
    }
}


function initCategorySelect() {
    const categorySelect = document.querySelector('.product-index_category-cont select');

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


function initCheckboxes() {
    const checkboxes = document.querySelectorAll('.product-index_checkboxes input');

    checkboxes.forEach(chb => {
        chb.addEventListener('change', () => {
            let allChecked = true;
            checkboxes.forEach(checkbox => {
                if (!checkbox.checked) allChecked = false;
            });

            if (allChecked) {
                checkboxes.forEach(checkbox => searchParams.delete(checkbox.name));
            } else {
                checkboxes.forEach(checkbox => searchParams.set(checkbox.name, checkbox.checked));
            }

            searchParams.delete('page');
            getTable();
        });
    });
}