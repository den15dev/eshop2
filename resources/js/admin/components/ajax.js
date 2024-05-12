import { csrf, lang } from "../../common/global.js";
import { showErrorMessage } from "../../common/modals.js";


export function post(
    service, // e.g. 'product' or 'category'
    action, // e.g. 'saveAttribute'
    args,
    errorFunc = () => {},
    successFunc = () => {},
) {
    fetch(`/${lang}/admin/ajax`, {
        method: 'post',
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({
            service: service,
            action: action,
            args: args,
        }),
    })
    .then(response => {
        if (!response.ok && response.status !== 422) {
            const error = new Error();
            error.status = response.status;
            error.statusText = response.statusText;
            throw error;
        }
        return response.json();
    })
    .then(result => {
        result.errors ? errorFunc(result) : successFunc(result);
    })
    .catch(err => showErrorMessage(err));
}