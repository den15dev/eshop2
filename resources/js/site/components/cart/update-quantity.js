import { productAddToCardBtn } from "./_constants.js";
import { updateCart } from "./update-cart.js";
import { updateCartCosts, updateCatalogCards, updateProductButton } from "./update-dom.js";

let qtyInputTimeout;

export function updateQuantity(qtyBtnsCont, sku_qty) {
    const qtyInput = qtyBtnsCont.querySelector('.quantity-btns_input');
    qtyInput.value = sku_qty ? sku_qty : 1;

    clearTimeout(qtyInputTimeout);

    qtyInputTimeout = setTimeout(() => {
        const sku_id = qtyBtnsCont.dataset.id;
        const parentCont = qtyBtnsCont.parentNode;

        if (parentCont.classList.contains('product-card_cart-btns-cont')) {
            // Catalog cards
            updateCart(sku_id, sku_qty, () => {
                updateCatalogCards(sku_id, sku_qty);
            });

        } else if (parentCont.classList.contains('product-main_add-btn-cont')) {
            // Product page
            const current_qty = parseInt(productAddToCardBtn.dataset.incart, 10);

            if (current_qty) {
                updateCart(sku_id, sku_qty, () => {
                    updateProductButton(sku_qty);
                });
            }

        } else if (parentCont.classList.contains('cart-item_qty-sum-cont')) {
            // Cart page
            updateCart(sku_id, sku_qty, (result) => {
                if (sku_qty) {
                    updateCartCosts(sku_id, parentCont.closest('.cart-item'), result);
                } else {
                    window.location.reload();
                }
            }, true);
        }

    }, 200);
}