import {submit403Messages, translations} from "../../common/global.js";
import {showClientModal} from "../../common/modals.js";
import {post} from "../components/ajax.js";

const deletePromoForm = document.querySelector('#deletePromoForm');
const promoImagesForm = document.querySelector('#promoImagesForm');
const promoSkuTable = document.querySelector('#promoSkuTable');

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

    if (promoImagesForm) {
        const imageInputs = promoImagesForm.querySelectorAll('input');
        const submitBtn = promoImagesForm.querySelector('button[type="submit"]');

        imageInputs.forEach(imgInput => {
            imgInput.addEventListener('change', () => {
                submitBtn.classList.remove('btn-inactive');
            });
        });
    }

    if (promoSkuTable) {
        const deleteBtns = promoSkuTable.querySelectorAll('.promo_table-btn.delete');

        deleteBtns.forEach(deleteBtn => {
            deleteBtn.addEventListener('click', () => {
                const sku_id = deleteBtn.parentNode.dataset.id;
                deleteSku(sku_id);
            });
        });
    }
}


function deleteSku(sku_id) {
    const args = {sku_id};

    post(
        'promo',
        'deleteSku',
        args,
        null,
        function () {
            window.location.reload();
        }
    );
}