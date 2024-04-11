import { fadeOut } from "../../../common/effects/fade.js";
import { cartHeaderBubble, catalogBtns, productAddToCardBtn, qtyBtnConts } from "./_constants.js";
import { updateCart } from "./update-cart.js";
import { updateQuantity } from "./update-quantity.js";
import {
    headerBubbleTimeout,
    setBubbleHidingTimeout,
    showHeaderBubble,
    updateCatalogCards,
    updateProductButton
} from "./update-dom.js";


export default function init() {
    if (catalogBtns.length) {
        catalogBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const sku_id = btn.dataset.id;
                const sku_qty = 1;
                updateCart(sku_id, sku_qty, (result) => {
                    updateCatalogCards(sku_id, sku_qty);
                    showHeaderBubble(result);
                });
            });
        });
    }

    if (productAddToCardBtn) {
        productAddToCardBtn.addEventListener('click', () => {
            const current_qty = parseInt(productAddToCardBtn.dataset.incart, 10);
            if (!current_qty) {
                const sku_id = productAddToCardBtn.dataset.id;
                const qtyInput = productAddToCardBtn.parentNode.querySelector('.quantity-btns_input');
                const sku_qty = parseInt(qtyInput.value, 10);

                updateCart(sku_id, sku_qty, (result) => {
                    updateProductButton(sku_qty);
                    showHeaderBubble(result);
                });
            }
        });
    }

    if (qtyBtnConts.length) {
        qtyBtnConts.forEach(qtyBtnCont => {
            const plusBtn = qtyBtnCont.querySelector('.quantity-btns_plus');
            const minusBtn = qtyBtnCont.querySelector('.quantity-btns_minus');
            const qtyInput = qtyBtnCont.querySelector('.quantity-btns_input');

            plusBtn.addEventListener('click', () => {
                const sku_qty = parseInt(qtyInput.value) + 1;
                updateQuantity(qtyBtnCont, sku_qty);
            });

            minusBtn.addEventListener('click', () => {
                const inputQty = parseInt(qtyInput.value);
                const sku_qty = inputQty ? inputQty - 1 : 0;
                updateQuantity(qtyBtnCont, sku_qty);
            });

            qtyInput.addEventListener('blur', () => {
                const inputQty = parseInt(qtyInput.value);
                const sku_qty = inputQty ? inputQty : 0;
                updateQuantity(qtyBtnCont, sku_qty);
            });
        });
    }

    initHeaderBubble();
}


function initHeaderBubble() {
    const bubbleCloseBtn = cartHeaderBubble.querySelector('.header-bubble_close-btn');

    bubbleCloseBtn.addEventListener('click', () => {
        fadeOut(cartHeaderBubble, 300);
    });

    cartHeaderBubble.addEventListener('mouseenter', () => {
        clearTimeout(headerBubbleTimeout);
    });

    cartHeaderBubble.addEventListener('mouseleave', () => {
        setBubbleHidingTimeout();
    });
}