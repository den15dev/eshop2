import { closeDropdown } from "../../common/dropdowns.js";
import { showClientModal } from "../../common/modals.js";
import { translations, ucfirst } from "../../common/global.js";
import { post, showFieldError } from "../components/ajax.js";

const attributeList = document.querySelector('.product-edit_attribute-list');
const changeCategoryBtn = document.querySelector('#changeCategoryBtn');


export default function init() {
    if (attributeList) {
        const items = document.querySelectorAll('.product-edit_attribute-item, .product-edit_variant-item');

        items.forEach(item => {
            const saveBtn = item.querySelector('.product-edit_attribute_save-btn');
            saveBtn?.addEventListener('click', () => {
                updateAttribute(item);
            });

            const addBtn = item.querySelector('.product-edit_attribute_add-btn');
            addBtn?.addEventListener('click', () => {
                createAttribute(item);
            });

            const deleteBtn = item.querySelector('.product-edit_attribute_delete-btn');
            deleteBtn?.addEventListener('click', () => {
                deleteAttribute(item);
            });

            const closeBtn = item.querySelector('.product-edit_attribute_close-btn');
            closeBtn.addEventListener('click', () => {
                closeDropdown(item.querySelector('.dropdown-btn'));
            });
        });
    }

    if (changeCategoryBtn) {
        handleCategoryChanging();
    }
}


function handleCategoryChanging() {
    const moveCategoryForm = changeCategoryBtn.closest('form');
    const categorySelect = document.querySelector('#productCategory');
    const oldCategoryId = categorySelect.value;

    changeCategoryBtn.addEventListener('click', event => {
        event.preventDefault();
        const newCategoryId = document.querySelector('#productCategory').value;

        if (newCategoryId !== oldCategoryId) {
            showClientModal({
                type: 'confirm',
                icon: 'warning',
                message: translations.messages.products.change_category,
                okAction: function () {
                    moveCategoryForm.submit();
                },
                okText: translations.messages.buttons.move,
            });
        }
    });
}


function updateAttribute(item) {
    const type = item.dataset.type;
    const action = 'update' + ucfirst(type);
    const id = item.dataset.id;
    const fieldsObj = getAttributeNameObj(item);
    const args = {
        id: id,
        fields: fieldsObj,
    };

    post(
        'product',
        action,
        args,
        function (result) {
            for (const fieldName in result.errors) {
                const input = getAttributeInputByFieldName(item, fieldName);
                if (input) showFieldError(input, result.errors[fieldName][0]);
            }
        },
        function () {
            window.location.reload();
        }
    );
}


function createAttribute(item) {
    const type = item.dataset.type;
    const action = 'create' + ucfirst(type);
    const fieldsObj = getAttributeNameObj(item);
    const args = {
        fields: fieldsObj,
    };

    switch (type) {
        case 'attribute':
            args.product_id = item.dataset.product;
            break;
        case 'variant':
            args.attribute_id = item.dataset.attribute;
            break;
    }

    post(
        'product',
        action,
        args,
        function (result) {
            for (const fieldName in result.errors) {
                const input = getAttributeInputByFieldName(item, fieldName);
                if (input) showFieldError(input, result.errors[fieldName][0]);
            }
        },
        function () {
            window.location.reload();
        }
    );
}


function deleteAttribute(item) {
    const type = item.dataset.type;
    let message;

    switch (type) {
        case 'attribute':
            message = translations.messages.products.delete_attribute;
            break;
        case 'variant':
            message = translations.messages.products.delete_variant;
            break;
    }

    showClientModal({
        type: 'confirm',
        icon: 'warning',
        message: message,
        okAction: function () {
            const action = 'delete' + ucfirst(type);
            const id = item.dataset.id;
            const args = {
                id: id
            };

            post(
                'product',
                action,
                args,
                () => {},
                function () {
                    window.location.reload();
                }
            );
        },
        okText: translations.messages.buttons.delete,
    });
}


function getAttributeNameObj(item) {
    const nameObj = {};
    const inputContainers = item.querySelectorAll('.product-edit_attribute_input-cont');

    inputContainers.forEach(cont => {
        const lang = cont.dataset.lang;
        const input = cont.querySelector('input');
        if (input.value) nameObj[lang] = input.value;
    });

    return nameObj;
}


function getAttributeInputByFieldName(item, fieldName) {
    let input;
    const lang = fieldName.split('.').pop();
    const inputConts = item.querySelectorAll('.product-edit_attribute_input-cont');

    inputConts.forEach(inputCont => {
        if (inputCont.dataset.lang === lang) {
            input = inputCont.querySelector('input');
        }
    });

    return input;
}
