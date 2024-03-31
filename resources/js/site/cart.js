import { cookieName, updateCart } from "./cart-handler.js";
import { showClientModal, showErrorMessage } from "../common/modals.js";
import { csrf, lang, translations } from "../common/global.js";

const removeItemBtns = document.querySelectorAll('.cart-item_btns .btn-icon');
const clearBtn = document.querySelector('#clearCartBtn');

const cartOrderForm = document.querySelector('#cartOrderForm');

let payMethodOnlineInput;
let submitBtnCheckoutText;
let submitBtnSubmitText;
let submitBtn;
let deliveryTypeInput;

if (cartOrderForm) {
    payMethodOnlineInput = cartOrderForm.querySelector('#payMethodOnlineCont input');
    submitBtn = cartOrderForm.querySelector('button[type="submit"]');
    submitBtnCheckoutText = submitBtn.dataset.checkout;
    submitBtnSubmitText = submitBtn.dataset.submit;
    deliveryTypeInput = cartOrderForm.delivery_type;
}

export default function init() {
    if (cartOrderForm) {
        handleTabSwitch();
        handlePaymentMethodSwitch();
    }

    if (removeItemBtns.length) {
        removeItemBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const sku_id = parseInt(btn.dataset.id, 10);
                updateCart(sku_id, 0, () => {
                    window.location.reload();
                });
            });
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            showClientModal({
                type: 'confirm',
                icon: 'confirm',
                message: translations.cart.messages.confirm_clear,
                okAction: clearCart,
                okText: translations.cart.clear_cart,
            });
        });
    }
}


function clearCart() {
    fetch(`/${lang}/clear-cart`, {
        method: 'post',
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({
            action: 'clear',
        }),
    })
    .then(response => {
        if (!response.ok) throw new Error(`${response.status} (${response.statusText})`);
        return response.json();
    })
    .then(result => {
        if (result.error_message) {
            throw new Error(result.error_message);
        } else if (!result.auth) {
            document.cookie = cookieName + '=; path=/; max-age=-1';
        }

        window.location.reload();
    })
    .catch(err => showErrorMessage(err.message));
}


function handleTabSwitch() {
    const deliveryTab = cartOrderForm.querySelector('#deliveryTab');
    const selfDeliveryTab = cartOrderForm.querySelector('#selfDeliveryTab');

    const PayMethodCardCont = cartOrderForm.querySelector('#payMethodCardCont');
    const PayMethodCashCont = cartOrderForm.querySelector('#payMethodCashCont');
    const PayMethodShopCont = cartOrderForm.querySelector('#payMethodShopCont');

    deliveryTab.addEventListener('click', () => {
        PayMethodShopCont.style.display = 'none';
        PayMethodCardCont.style.display = 'block';
        PayMethodCashCont.style.display = 'block';
        payMethodOnlineInput.checked = true;
        switchSubmitBtn();
        deliveryTypeInput.value = 'delivery';
    });

    selfDeliveryTab.addEventListener('click', () => {
        PayMethodShopCont.style.display = 'block';
        PayMethodCardCont.style.display = 'none';
        PayMethodCashCont.style.display = 'none';
        payMethodOnlineInput.checked = true;
        switchSubmitBtn();
        deliveryTypeInput.value = 'self-delivery';
    });
}


function handlePaymentMethodSwitch() {
    const payMethodCont = cartOrderForm.querySelector('#payMethodCont');
    const payMethodInputs = payMethodCont.querySelectorAll('input');

    payMethodInputs.forEach(payMethodInput => {
        payMethodInput.addEventListener('change', switchSubmitBtn);
    });
}


function switchSubmitBtn() {
    submitBtn.innerText = payMethodOnlineInput.checked
        ? submitBtnCheckoutText
        : submitBtnSubmitText;
}