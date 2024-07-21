import Sortable from "sortablejs";
import {post, convertToNestedObjects, removeEmptyObjects, showFieldErrors} from "../components/ajax.js";
import {showClientModal} from "../../common/modals.js";
import {submit403Messages, translations} from "../../common/global.js";

const catOrderList = document.querySelector('#childCategoryOrderList');
const catSpecifications = document.querySelector('#categorySpecifications');
const deleteCategoryForm = document.querySelector('#deleteCategoryForm');


export default function init() {
    if (catOrderList) {
        const orderInput = document.querySelector('#childCategoryOrderInput');
        const catOrderSortable = Sortable.create(catOrderList, {
            animation: 150,
            onUpdate: () => {
                const ids = [];
                catOrderSortable.toArray().forEach(id => ids.push(parseInt(id, 10)));
                orderInput.value = JSON.stringify(ids);
            },
        });
    }

    if (catSpecifications) {
        const specForms = catSpecifications.querySelectorAll('form');
        const categoryId = catSpecifications.dataset.categoryId;

        specForms.forEach(specForm => {
            const specId = specForm.dataset.specId;
            const saveBtn = specForm.querySelector('.spec-item_save-btn');
            const deleteBtn = specForm.querySelector('.spec-item_delete-btn');

            saveBtn.addEventListener('click', () => {
                updateOrAddSpec(categoryId, specId, specForm, 'updateSpec');
            });

            deleteBtn.addEventListener('click', () => {
                deleteSpec(specId, specForm);
            });
        });

        const addSpecForm = document.querySelector('#categoryAddSpec form');
        const addBtn = addSpecForm.querySelector('.spec-item_add-btn');

        addBtn.addEventListener('click', () => {
            updateOrAddSpec(categoryId, null, addSpecForm, 'storeSpec');
        });
    }

    if (deleteCategoryForm) {
        const deleteCategoryBtn = deleteCategoryForm.querySelector('button[type="submit"]');

        if (!submit403Messages) {
            deleteCategoryBtn.addEventListener('click', e => {
                e.preventDefault();
                const categoryName = deleteCategoryBtn.dataset.name;
                const message = translations.messages.categories.delete_category.replace(':name', categoryName);

                showClientModal({
                    type: 'confirm',
                    icon: 'warning',
                    message: message,
                    okText: translations.admin_general.delete,
                    okAction: () => deleteCategoryForm.submit(),
                });
            });
        }
    }
}


function updateOrAddSpec(category_id, spec_id, specForm, action) {
    validateSpecOrderNum(specForm);

    const specFormData = new FormData(specForm);
    let fields = Object.fromEntries(specFormData.entries());
    fields = convertToNestedObjects(fields);
    fields = removeEmptyObjects(fields);

    const args = {category_id, fields};
    if (spec_id) args['spec_id'] = spec_id;

    post(
        'category',
        action,
        args,
        function (result) {
            showClientModal({
                icon: 'success',
                message: result.message,
                reloadOnClose: true,
            });
        },
        function (result) {
            showFieldErrors(specForm, result.errors);
        }
    );
}


function deleteSpec(spec_id, specForm) {
    const specName = specForm.querySelector('*[data-current-name="true"]').value;

    showClientModal({
        type: 'confirm',
        icon: 'warning',
        message: translations.messages.categories.delete_spec.replace(':name', specName),
        okAction: function () {
            post(
                'category',
                'deleteSpec',
                { spec_id },
                function (result) {
                    showClientModal({
                        icon: 'success',
                        message: result.message,
                        reloadOnClose: true,
                    });
                },
                function (result) {
                    console.error(result.errors);
                }
            );
        },
        closeOnOk: false,
        okText: translations.messages.buttons.delete,
    });
}


function validateSpecOrderNum(specForm) {
    const oldSortNum = specForm.querySelector('input[name="old_sort"]')?.value;
    const orderInput = specForm.querySelector('input[name="sort"]');
    const specForms = catSpecifications.querySelectorAll('form');
    const specNum = specForms.length;
    const newSortNum = parseInt(orderInput.value, 10);

    if (oldSortNum) { // Updating spec
        if (!newSortNum) {
            orderInput.value = oldSortNum;

        } else if (newSortNum > specNum) {
            orderInput.value = specNum;
        }
    } else { // Adding new spec
        if (!newSortNum || newSortNum > (specNum + 1)) {
            orderInput.value = specNum + 1;
        }
    }
}
