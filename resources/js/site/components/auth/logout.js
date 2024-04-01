import { showClientModal } from "../../../common/modals.js";
import { translations } from "../../../common/global.js";


export function logOut(logoutBtn) {
    const formElem = logoutBtn.parentNode;
    const formData = new FormData(formElem);

    fetch(formElem.action, {
        method: 'post',
        headers: { 'Accept': 'application/json' },
        body: new URLSearchParams(formData),
    })
    .then(response => {
        if (!response.ok && response.status !== 422) throw new Error(`${response.status}`);
        return response.json();
    })
    .then(result => {
        if (result.status === 'logout') {
            window.location.reload();
        }
    })
    .catch(err => {
        showClientModal({
            message: `${translations.general.messages.error} ${err.message}`,
            icon: 'warning',
        });
    });
}