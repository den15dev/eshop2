import { csrf, lang } from "../../../common/global.js";
import { showErrorMessage } from "../../../common/modals.js";
import { updateCookie } from "./update-cookie.js";
import { updateBadges } from "./update-dom.js";


export function updateCart(sku_id, sku_qty, updateDOM, get_cost = false) {
    fetch(`/${lang}/cart/update`, {
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