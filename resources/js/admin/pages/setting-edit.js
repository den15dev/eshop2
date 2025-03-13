import { post } from "../components/ajax.js";
import {showClientModal} from "../../common/modals.js";

const switches = document.querySelectorAll('#settingsPage .form-switch input');
let switchPreloader, switchInput;

export default function init() {
    switches.forEach(curSwitch => {
        curSwitch.addEventListener('change', () => {
            switchInput = curSwitch;
            switchPreloader = switchInput.closest('.preloader-cont').querySelector('.preloader');

            switchPreloader.classList.remove('hidden');
            switchSetting(switchInput);
        });
    });
}


function switchSetting(switchInput) {
    post(
        'setting',
        'updateBooleanSetting',
        {
            setting_id: switchInput.id,
            is_checked: switchInput.checked
        },
        function (result) {
            switchPreloader.classList.add('hidden');
            showClientModal({
                icon: 'success',
                message: result.message,
            });
        },
        fallbackSwitch,
        fallbackSwitch
    );
}


function fallbackSwitch() {
    switchInput.checked = !switchInput.checked;
    switchPreloader.classList.add('hidden');
}
