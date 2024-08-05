import {getCookieValue, translations} from "../../common/global.js";
import {showClientModal} from "../../common/modals.js";

const cookieName = 'demonote';
const demoNoteCookie = getCookieValue(cookieName);

export default function init() {
    if (!demoNoteCookie) {
        document.addEventListener('translations_loaded', () => {
            showClientModal({
                message: translations.general.demo_note,
            });

            document.cookie = cookieName + '=1; path=/; max-age=31536000';
        });
    }
}