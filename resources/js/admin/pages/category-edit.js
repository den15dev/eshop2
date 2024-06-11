import Sortable from "sortablejs";
import {post, convertToNestedObjects, removeEmptyObjects, showFieldErrors} from "../components/ajax.js";
import {showClientModal} from "../../common/modals.js";
import {translations, ucfirst} from "../../common/global.js";

const catOrderList = document.querySelector('#childCategoryOrderList');
const catSpecifications = document.querySelector('#categorySpecifications');


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

        specForms.forEach(specForm => {
            const specId = specForm.dataset.specId;
            const categoryId = specForm.dataset.categoryId;
            const saveBtn = specForm.querySelector('.spec-item_save-btn');
            const deleteBtn = specForm.querySelector('.spec-item_delete-btn');

            saveBtn.addEventListener('click', () => {
                updateSpec(categoryId, specId, specForm);
            });

            deleteBtn.addEventListener('click', () => {
                deleteSpec(specId, specForm);
            });
        });
    }
}


function updateSpec(category_id, spec_id, specForm) {
    validateSpecOrderNum(specForm);

    const specFormData = new FormData(specForm);
    let fields = Object.fromEntries(specFormData.entries());
    fields = convertToNestedObjects(fields);
    fields = removeEmptyObjects(fields);

    const args = {category_id, spec_id, fields};

    post(
        'category',
        'updateSpec',
        args,
        function (result) {
            showFieldErrors(specForm, result.errors);
        },
        function (result) {
            showClientModal({
                icon: 'success',
                message: result.message,
                reloadOnClose: true,
            });
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
                    console.error(result.errors);
                },
                function (result) {
                    showClientModal({
                        icon: 'success',
                        message: result.message,
                        reloadOnClose: true,
                    });
                }
            );
        },
        closeOnOk: false,
        okText: translations.messages.buttons.delete,
    });
}


function validateSpecOrderNum(specForm) {
    const oldSortNum = specForm.querySelector('input[name="old_sort"]').value;
    const orderInput = specForm.querySelector('input[name="sort"]');
    const specForms = catSpecifications.querySelectorAll('form');
    const specNum = specForms.length;
    const newSortNum = parseInt(orderInput.value, 10);

    if (!newSortNum) {
        orderInput.value = oldSortNum;

    } else if (newSortNum > specNum) {
        orderInput.value = specNum;
    }
}
