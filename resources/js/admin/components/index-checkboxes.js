import { getTable } from "./index-table.js";
import { searchParams } from "./set-url-query.js";


export default function init() {
    const checkboxes = document.querySelectorAll('.index_checkboxes input');

    if (checkboxes.length) {
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
}