import { getCookieValue } from "../../../common/global.js";

const cookieName = 'cart';


export function updateCookie(sku_id, sku_qty) {
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
        setCookie(cart);
    } else {
        removeCookie();
    }

    return cart;
}


function setCookie(cart) {
    document.cookie = cookieName + '=' + encodeURIComponent(JSON.stringify(cart)) + '; path=/; max-age=2592000';
}

export function removeCookie() {
    document.cookie = cookieName + '=; path=/; max-age=-1';
}