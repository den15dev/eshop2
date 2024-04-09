import { showClientModal } from "../../common/modals.js";
import { translations } from "../../common/global.js";
import { updateCart } from "../components/cart/update-cart.js";
import { clearCart } from "../components/cart/clear-cart.js";
import { switchTabTo } from "../../common/tabs.js";

const deliveryMethod = {
    delivery: 'delivery',
    self_delivery: 'self-delivery',
};

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
    deliveryTypeInput = cartOrderForm.delivery_method;
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


function handleTabSwitch() {
    const tabCont = cartOrderForm.querySelector('.tab-cont');
    const deliveryTab = cartOrderForm.querySelector('#deliveryTab');
    const selfDeliveryTab = cartOrderForm.querySelector('#selfDeliveryTab');

    deliveryTab.addEventListener('click', () => {
        switchPaymentMethods(deliveryMethod.delivery);
        payMethodOnlineInput.checked = true;
        switchSubmitBtn();
        deliveryTypeInput.value = deliveryMethod.delivery;
    });

    selfDeliveryTab.addEventListener('click', () => {
        switchPaymentMethods(deliveryMethod.self_delivery);
        payMethodOnlineInput.checked = true;
        switchSubmitBtn();
        deliveryTypeInput.value = deliveryMethod.self_delivery;
    });

    // If validation failed and self-delivery was selected, switch to self-delivery
    if (deliveryTypeInput.value === deliveryMethod.self_delivery) {
        switchTabTo(tabCont, selfDeliveryTab);
        switchPaymentMethods(deliveryMethod.self_delivery);
        switchSubmitBtn();
    }
}


function handlePaymentMethodSwitch() {
    const payMethodCont = cartOrderForm.querySelector('#payMethodCont');
    const payMethodInputs = payMethodCont.querySelectorAll('input');

    payMethodInputs.forEach(payMethodInput => {
        payMethodInput.addEventListener('change', switchSubmitBtn);
    });
}


function switchPaymentMethods(deliveryMethodValue) {
    const PayMethodCardCont = cartOrderForm.querySelector('#payMethodCardCont');
    const PayMethodCashCont = cartOrderForm.querySelector('#payMethodCashCont');
    const PayMethodShopCont = cartOrderForm.querySelector('#payMethodShopCont');

    switch (deliveryMethodValue) {
        case deliveryMethod.delivery:
            PayMethodShopCont.style.display = 'none';
            PayMethodCardCont.style.display = 'block';
            PayMethodCashCont.style.display = 'block';
            break;

        case deliveryMethod.self_delivery:
            PayMethodShopCont.style.display = 'block';
            PayMethodCardCont.style.display = 'none';
            PayMethodCashCont.style.display = 'none';
            break;
    }
}


function switchSubmitBtn() {
    submitBtn.innerText = payMethodOnlineInput.checked
        ? submitBtnCheckoutText
        : submitBtnSubmitText;
}