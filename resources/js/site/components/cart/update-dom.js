import { cartHeaderBubble, productAddToCardBtn, productGoToCardBtn } from "./_constants.js";
import { fadeIn, fadeOut } from "../../../common/effects/fade.js";
import { lgMedia } from "../../../common/global.js";


const badgeDesktop = document.querySelector('#cartBadgeDesktop');
const badgeMobile = document.querySelector('#cartBadgeMobile');
export let headerBubbleTimeout;
const bubbleFadeSpeed = 300;

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
    productAddToCardBtn.dataset.incart = sku_qty;

    if (sku_qty) {
        productAddToCardBtn.classList.add('hidden');
        productGoToCardBtn.classList.remove('hidden');

    } else {
        productAddToCardBtn.classList.remove('hidden');
        productGoToCardBtn.classList.add('hidden');
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


export function showHeaderBubble(result) {
    if (lgMedia.matches) {
        const imgLink = cartHeaderBubble.querySelector('.cart-header-bubble_img-link');
        const img = imgLink.querySelector('img');
        const titleLink = cartHeaderBubble.querySelector('.cart-header-bubble_title a');
        const qty = cartHeaderBubble.querySelector('.cart-header-bubble_qty');
        const data = result.header_bubble;

        imgLink.href = data.url;
        img.src = data.image_tn;
        img.alt = data.name;
        titleLink.href = data.url;
        titleLink.innerText = data.name;
        qty.innerText = data.qty;

        fadeIn(cartHeaderBubble, bubbleFadeSpeed);

        clearTimeout(headerBubbleTimeout);
        setBubbleHidingTimeout();
    }
}

export function setBubbleHidingTimeout() {
    headerBubbleTimeout = setTimeout(() => {
        fadeOut(cartHeaderBubble, bubbleFadeSpeed * 2);
    }, 4000);
}