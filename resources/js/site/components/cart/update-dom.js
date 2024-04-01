import { productBtn } from "./_constants.js"
import { translations } from "../../../common/global.js";

const badgeDesktop = document.querySelector('#cartBadgeDesktop');
const badgeMobile = document.querySelector('#cartBadgeMobile');

export function updateCartCosts(sku_id, cartItemElem, result) {
    // Update price
    const priceCont = cartItemElem.querySelector('.cart-item_id-price .product-card_old-price del');
    if (priceCont) priceCont.innerText = result.item.price_formatted;

    const priceMobileCont = cartItemElem.querySelector('.cart-item_id-price-mobile .product-card_old-price del');
    if (priceMobileCont) priceMobileCont.innerText = result.item.price_formatted;

    const finalPriceCont = cartItemElem.querySelector('.cart-item_id-price .product-card_price');
    finalPriceCont.innerText = result.item.final_price_formatted;

    const finalPriceMobileCont = cartItemElem.querySelector('.cart-item_id-price-mobile .product-card_price');
    finalPriceMobileCont.innerText = result.item.final_price_formatted;

    // Update cost
    const costCont = cartItemElem.querySelector('.cart-item_sum .product-card_old-price del');
    if (costCont) costCont.innerText = result.item.cost_formatted;

    const finalCostCont = cartItemElem.querySelector('.cart-item_sum .product-card_price');
    finalCostCont.innerText = result.item.final_cost_formatted;

    // Update total cost
    const totalCont = document.querySelector('.cart-total_sum .product-card_old-price del');
    if (totalCont) totalCont.innerText = result.total.cost_formatted;

    const finalTotalCont = document.querySelector('.cart-total_sum .product-card_price');
    finalTotalCont.innerText = result.total.final_cost_formatted;
}


export function updateProductButton(sku_qty) {
    productBtn.dataset.incart = sku_qty;

    if (sku_qty) {
        productBtn.classList.add('btn-bg-grey');
        productBtn.innerText = translations.cart.buttons.in_cart;
    } else {
        productBtn.classList.remove('btn-bg-grey');
        productBtn.innerText = translations.cart.buttons.add_to_cart;
    }
}


export function updateCatalogCards(sku_id, sku_qty) {
    const catalogBtns = document.querySelectorAll(`.catalog-add-to-cart-btn[data-id="${sku_id}"]`);

    catalogBtns.forEach(catBtn => {
        const qtyBtnsCont = catBtn.parentNode.querySelector('.quantity-btns_cont');
        const qtyInput = qtyBtnsCont.querySelector('.quantity-btns_input');

        if (sku_qty) {
            if (qtyBtnsCont.classList.contains('hidden')) {
                showQuantityButtons(catBtn, qtyBtnsCont);
            }
        } else {
            hideQuantityButtons(catBtn, qtyBtnsCont);
        }

        qtyInput.value = sku_qty;
    });
}


function showQuantityButtons(btn, qtyBtnsCont) {
    btn.classList.add('hidden');
    qtyBtnsCont.classList.remove('hidden');
}

function hideQuantityButtons(btn, qtyBtnsCont) {
    qtyBtnsCont.classList.add('hidden');
    btn.classList.remove('hidden');
}

export function updateBadges(items_num) {
    badgeDesktop.innerText = items_num;
    badgeMobile.innerText = items_num;

    if (items_num) {
        badgeDesktop.classList.add('active');
        badgeMobile.classList.add('active');
    } else {
        badgeDesktop.classList.remove('active');
        badgeMobile.classList.remove('active');
    }
}