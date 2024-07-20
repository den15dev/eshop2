import { tableName, searchParams } from "../components/index-table.js";
import { getTable } from "../components/index-table.js";


export default function init() {
    if (tableName === 'users') {
        initCheckboxes();
    }
}


function initCheckboxes() {
    const checkboxes = document.querySelectorAll('.index_checkboxes input');

    checkboxes.forEach(chb => {
        chb.addEventListener('change', () => {
            let allUnchecked = true;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) allUnchecked = false;
            });

            if (allUnchecked) {
                checkboxes.forEach(checkbox => searchParams.delete(checkbox.name));
            } else {
                checkboxes.forEach(checkbox => {
                    checkbox.checked
                        ? searchParams.set(checkbox.name, checkbox.checked)
                        : searchParams.delete(checkbox.name);
                });
            }

            searchParams.delete('page');
            getTable();
        });
    });
}
