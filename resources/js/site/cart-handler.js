import {csrf, getCookieValue, lang, translations} from "../common/global.js";
import { showErrorMessage } from "../common/modals.js";

const badgeDesktop = document.querySelector('#cartBadgeDesktop');
const badgeMobile = document.querySelector('#cartBadgeMobile');

export const cookieName = 'cart';

const catalogBtns = document.querySelectorAll('.catalog-add-to-cart-btn');
const productBtn = document.querySelector('#productAddToCartBtn');
const qtyBtnConts = document.querySelectorAll('.quantity-btns_cont');

let qtyInputTimeout;


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


export function updateCart(sku_id, sku_qty, updateDOM, get_cost = false) {
    fetch(`/${lang}/update-cart`, {
        method: 'post',
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({
            sku_id: sku_id,
            sku_qty: sku_qty,
            get_cost: get_cost,
        }),
    })
    .then(response => {
        if (!response.ok) throw new Error(`${response.status} (${response.statusText})`);
        return response.json();
    })
    .then(result => {
        let cart;

        if (result.auth) {
            cart = result.cart;
        } else {
            cart = updateCookie(sku_id, sku_qty);
        }

        updateDOM(result);
        updateBadges(cart.length);
    })
    .catch(err => showErrorMessage(err.message));
}


function updateCookie(sku_id, sku_qty) {
    const cartCookie = getCookieValue(cookieName);
    let cart = cartCookie ? JSON.parse(decodeURIComponent(cartCookie)) : [];

    sku_id = parseInt(sku_id, 10);
    let inCart = false;
    cart.forEach(cartItem => {
        if (cartItem[0] === sku_id) {
            cartItem[1] = sku_qty;
            inCart = true;
        }
    });

    if (!inCart) {
        cart.push([sku_id, sku_qty]);
    }

    cart = cart.filter(cartItem => cartItem[1] > 0);

    if (cart.length) {
        document.cookie = cookieName + '=' + encodeURIComponent(JSON.stringify(cart)) + '; path=/; max-age=2592000';
    } else {
        document.cookie = cookieName + '=; path=/; max-age=-1';
    }

    return cart;
}


function updateQuantity(qtyBtnsCont, sku_qty) {
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
            const current_qty = parseInt(productBtn.dataset.incart, 10);

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


function updateCartCosts(sku_id, cartItemElem, result) {
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


function updateProductButton(sku_qty) {
    productBtn.dataset.incart = sku_qty;

    if (sku_qty) {
        productBtn.classList.add('btn-bg-grey');
        productBtn.innerText = translations.cart.buttons.in_cart;
    } else {
        productBtn.classList.remove('btn-bg-grey');
        productBtn.innerText = translations.cart.buttons.add_to_cart;
    }
}


function updateCatalogCards(sku_id, sku_qty) {
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

function updateBadges(items_num) {
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