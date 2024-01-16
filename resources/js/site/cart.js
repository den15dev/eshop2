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