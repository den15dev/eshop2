import {submit403Messages, translations} from "../../common/global.js";
import {showClientModal} from "../../common/modals.js";

const cancelOrderForm = document.querySelector('#cancelOrderForm');

export default function init() {
    if (cancelOrderForm && !submit403Messages) {
        const cancelOrderBtn = cancelOrderForm.querySelector('button[type="submit"]');

        cancelOrderBtn.addEventListener('click', e => {
            e.preventDefault();

            showClientModal({
                type: 'confirm',
                icon: 'warning',
                message: translations.messages.orders.cancel_order,
                okText: translations.admin_general.cancel,
                cancelText: translations.admin_general.close,
                okAction: () => cancelOrderForm.submit(),
            });
        });
    }
}