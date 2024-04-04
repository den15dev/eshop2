import { csrf, lang } from "../../../common/global.js";
import { showErrorMessage } from "../../../common/modals.js";
import { removeCookie } from "./update-cookie.js";

export function clearCart() {
    fetch(`/${lang}/cart/clear`, {
        method: 'post',
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({
            action: 'clear',
        }),
    })
    .then(response => {
        if (!response.ok) throw new Error(`${response.status} (${response.statusText})`);
        return response.json();
    })
    .then(result => {
        if (result.error_message) {
            throw new Error(result.error_message);
        } else if (!result.auth) {
            removeCookie();
        }

        window.location.reload();
    })
    .catch(err => showErrorMessage(err.message));
}