import {submit403Messages, translations} from "../../common/global.js";
import {showClientModal} from "../../common/modals.js";

const deleteBrandForm = document.querySelector('#deleteBrandForm');


export default function init() {
    if (deleteBrandForm) {
        const deleteBrandBtn = deleteBrandForm.querySelector('button[type="submit"]');

        if (!submit403Messages) {
            deleteBrandBtn.addEventListener('click', e => {
                e.preventDefault();
                const brandName = deleteBrandBtn.dataset.name;
                const message = translations.messages.brands.delete_brand.replace(':name', brandName);

                showClientModal({
                    type: 'confirm',
                    icon: 'warning',
                    message: message,
                    okText: translations.admin_general.delete,
                    okAction: () => deleteBrandForm.submit(),
                });
            });
        }
    }
}