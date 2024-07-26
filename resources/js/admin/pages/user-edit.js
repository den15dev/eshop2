import { post } from "../components/ajax.js";
import {submit403Messages, translations} from "../../common/global.js";
import {showClientModal} from "../../common/modals.js";

const banUserSection = document.querySelector('#banUserSection');
let banSwitchInput, banSwitchPreloader;

const changeRoleForm = document.querySelector('#changeRoleForm');
const deleteUserForm = document.querySelector('#deleteUserForm');


export default function init() {
    if (banUserSection) {
        const user_id = banUserSection.dataset.id;
        banSwitchInput = banUserSection.querySelector('#userBanSwitch');
        banSwitchPreloader = banUserSection.querySelector('.preloader');

        banSwitchInput.addEventListener('change', () => {
            banSwitchPreloader.classList.remove('hidden');
            switchUserBan(user_id, banSwitchInput.checked);
        });
    }
    
    if (changeRoleForm && !submit403Messages) {
        const userName = changeRoleForm.dataset.name;
        const changeRoleBtn = changeRoleForm.querySelector('button[type="submit"]');
        const role = changeRoleForm.querySelector('input[name="role"]').value;

        changeRoleBtn.addEventListener('click', e => {
            e.preventDefault();

            showClientModal({
                type: 'confirm',
                icon: 'confirm',
                message: translations.messages.users[`make_${role}`].replace(':name', userName),
                okText: translations.admin_general.proceed,
                cancelText: translations.admin_general.cancel,
                okAction: () => changeRoleForm.submit(),
            });
        });
    }

    if (deleteUserForm && !submit403Messages) {
        const userName = deleteUserForm.dataset.name;
        const deleteUserBtn = deleteUserForm.querySelector('button[type="submit"]');

        deleteUserBtn.addEventListener('click', e => {
            e.preventDefault();

            showClientModal({
                type: 'confirm',
                icon: 'warning',
                message: translations.messages.users.delete_user.replace(':name', userName),
                okText: translations.admin_general.delete,
                cancelText: translations.admin_general.cancel,
                okAction: () => deleteUserForm.submit(),
            });
        });
    }
}


function switchUserBan(user_id, banned) {
    post(
        'user',
        'updateBanStatus',
        {user_id, banned},
        function (result) {
            banSwitchPreloader.classList.add('hidden');
            showClientModal({
                icon: 'success',
                message: result.message,
            });
        },
        fallbackBanSwitch,
        fallbackBanSwitch
    );
}


function fallbackBanSwitch() {
    banSwitchInput.checked = !banSwitchInput.checked;
    banSwitchPreloader.classList.add('hidden');
}