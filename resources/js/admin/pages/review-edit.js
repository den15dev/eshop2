import {submit403Messages, translations} from "../../common/global.js";
import {showClientModal} from "../../common/modals.js";

const reviewDeleteForm = document.querySelector('#reviewDeleteForm');

export default function init() {
    if (reviewDeleteForm && !submit403Messages) {
        const reviewDeleteBtn = document.querySelector('#reviewDeleteBtn');

        reviewDeleteBtn.addEventListener('click', e => {
            e.preventDefault();

            showClientModal({
                type: 'confirm',
                icon: 'confirm',
                message: translations.messages.reviews.delete_review,
                okText: translations.admin_general.delete,
                cancelText: translations.admin_general.cancel,
                okAction: () => reviewDeleteForm.submit(),
            });
        });
    }
}