import {submit403Messages, translations} from "../../common/global.js";
import {showClientModal} from "../../common/modals.js";

const deletePromoForm = document.querySelector('#deletePromoForm');


export default function init() {
    if (deletePromoForm) {
        const deletePromoBtn = deletePromoForm.querySelector('button[type="submit"]');

        if (!submit403Messages) {
            deletePromoBtn.addEventListener('click', e => {
                e.preventDefault();
                const promoName = deletePromoBtn.dataset.name;
                const message = translations.messages.promos.delete_promo.replace(':name', promoName);

                showClientModal({
                    type: 'confirm',
                    icon: 'warning',
                    message: message,
                    okText: translations.admin_general.delete,
                    okAction: () => deletePromoForm.submit(),
                });
            });
        }
    }
}