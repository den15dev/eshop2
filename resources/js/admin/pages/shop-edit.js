import {post} from "../components/ajax.js";
import {showClientModal} from "../../common/modals.js";
import {submit403Messages, translations} from "../../common/global.js";

const shopSwitchSection = document.querySelector('#shopSwitchSection');
let shopActiveInput, shopActivePreloader;

const deleteShopForm = document.querySelector('#deleteShopForm');

export default function init() {
    if (shopSwitchSection) {
        const shop_id = shopSwitchSection.dataset.id;
        shopActiveInput = shopSwitchSection.querySelector('#shopActiveSwitch');
        shopActivePreloader = shopSwitchSection.querySelector('.preloader');

        shopActiveInput.addEventListener('change', () => {
            shopActivePreloader.classList.remove('hidden');
            switchShopActiveness(shop_id, shopActiveInput.checked);
        });
    }

    if (deleteShopForm) {
        const deleteShopBtn = deleteShopForm.querySelector('button[type="submit"]');

        if (!submit403Messages) {
            deleteShopBtn.addEventListener('click', e => {
                e.preventDefault();
                const shopName = deleteShopBtn.dataset.name;
                const message = translations.messages.shops.delete_shop.replace(':name', shopName);

                showClientModal({
                    type: 'confirm',
                    icon: 'warning',
                    message: message,
                    okText: translations.admin_general.delete,
                    okAction: () => deleteShopForm.submit(),
                });
            });
        }
    }
}


function switchShopActiveness(shop_id, is_active) {
    post(
        'shop',
        'updateActiveStatus',
        {shop_id, is_active},
        function (result) {
            shopActivePreloader.classList.add('hidden');
            showClientModal({
                icon: 'success',
                message: result.message,
            });
        },
        fallbackSwitch,
        fallbackSwitch
    );
}


function fallbackSwitch() {
    shopActiveInput.checked = !shopActiveInput.checked;
    shopActivePreloader.classList.add('hidden');
}