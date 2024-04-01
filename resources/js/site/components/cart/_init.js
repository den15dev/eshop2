import { catalogBtns, productBtn, qtyBtnConts } from "./_constants.js"
import { updateCart } from "./update-cart.js";
import { updateQuantity } from "./update-quantity.js";
import { updateCatalogCards, updateProductButton } from "./update-dom.js";


export default function init() {
    if (catalogBtns.length) {
        catalogBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const sku_id = btn.dataset.id;
                const sku_qty = 1;
                updateCart(sku_id, sku_qty, () => {
                    updateCatalogCards(sku_id, sku_qty);
                });
            });
        });
    }

    if (productBtn) {
        productBtn.addEventListener('click', () => {
            const sku_id = productBtn.dataset.id;
            const current_qty = parseInt(productBtn.dataset.incart, 10);
            const qtyInput = productBtn.parentNode.querySelector('.quantity-btns_input');
            const input_qty = parseInt(qtyInput.value, 10);
            const sku_qty = current_qty ? 0 : input_qty;

            updateCart(sku_id, sku_qty, () => {
                updateProductButton(sku_qty);
            });
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
}