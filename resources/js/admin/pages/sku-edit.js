import {get, post, showFieldErrors} from "../components/ajax.js"
import Sortable from 'sortablejs';
import { Fancybox } from "@fancyapps/ui";
import { showClientModal } from "../../common/modals.js";
import { submit403Messages, translations } from "../../common/global.js";

const skuEditMainForm = document.querySelector('#skuEditMainForm');
const skuCreateForm = document.querySelector('#skuCreateForm');
const imagesCont = document.querySelector('.sku-edit_images');
const skuSpecsCont = document.querySelector('#skuSpecifications');
const removeSkuForm = document.querySelector('#removeSkuForm');

let priceInput;
let currencySelect;
let discountInput;
let promoSelect;
let priceInputTimeout;
let skuId;


export default function init() {
    if (skuEditMainForm || skuCreateForm) {
        priceInput = document.querySelector('#price');
        currencySelect = document.querySelector('#currency');
        discountInput = document.querySelector('#discount');
        promoSelect = document.querySelector('#promo');

        // Always fill prices and promo info for cases
        // after coming back with failed validation
        fillPromoInfo();
        getSkuFinalPrices();

        priceInput.addEventListener('input', () => {
            getSkuFinalPrices();
        });

        currencySelect.addEventListener('change', () => {
            getSkuFinalPrices();
        });

        discountInput.addEventListener('input', () => {
            getSkuFinalPrices();
        });

        promoSelect.addEventListener('change', () => {
            fillPromoInfo();
            getSkuFinalPrices();
        });
    }

    if (imagesCont) {
        const imageItems = document.querySelectorAll('.sku-edit_image-item');
        const newImageInput = document.querySelector('#skuNewImage');

        const imageSortable = Sortable.create(imagesCont, {
            animation: 150,
            onUpdate: () => {
                updateImageList();
                activateImageSubmitBtn();
            },
        });

        Fancybox.bind('[data-fancybox]', {
            wheel: 'slide',
            Thumbs: {
                type: "classic",
            },
        });

        imageItems.forEach(item => {
            const closeBtn = item.querySelector('.sku-edit_image-item_close-btn');

            closeBtn.addEventListener('click', () => {
                item.remove();
                updateImageList();
                activateImageSubmitBtn();
            });
        });

        newImageInput.addEventListener('change', () => {
            activateImageSubmitBtn();
        });
    }

    if (skuSpecsCont) {
        skuId = skuSpecsCont.dataset.skuId;
        const specItems = skuSpecsCont.querySelectorAll('.spec-item');

        specItems.forEach(item => {
            const specForm = item.querySelector('form');
            const clearBtn = item.querySelector('.spec-item_clear-btn');
            const saveBtn = item.querySelector('.spec-item_save-btn');

            clearBtn.addEventListener('click', () => {
                const tAreas = item.querySelectorAll('textarea');

                tAreas.forEach(tArea => tArea.value = '');
            });

            saveBtn.addEventListener('click', () => {
                isClearedSpec(specForm)
                    ? deleteSpec(skuId, specForm)
                    : updateSpec(skuId, specForm);
            });
        });
    }

    if (removeSkuForm) {
        const removeSkuBtn = removeSkuForm.querySelector('button[type="submit"]');

        if (!submit403Messages) {
            removeSkuBtn.addEventListener('click', e => {
                e.preventDefault();

                showClientModal({
                    type: 'confirm',
                    icon: 'warning',
                    message: translations.messages.products.delete_sku,
                    okText: translations.admin_general.delete,
                    okAction: () => removeSkuForm.submit(),
                });
            });
        }
    }
}


function getPriceData() {
    return {
        price: parseFloat(priceInput.value.replace(',', '.')) || 0,
        currency_id: currencySelect.value,
        sku_discount: parseInt(discountInput.value) || 0,
        promo_id: parseInt(promoSelect.value) || 0,
    };
}


function insertPriceData(result) {
    const section = document.querySelector('#finalPriceSection');
    const finalDiscount = section.querySelector('#finalDiscount');
    const finalPrices = section.querySelectorAll('span[data-currency]');

    finalDiscount.innerText = result.discount;
    finalPrices.forEach(priceSpan => {
        priceSpan.innerHTML = result[priceSpan.dataset.currency];
    });
}


function getSkuFinalPrices() {
    clearTimeout(priceInputTimeout);
    priceInputTimeout = setTimeout(() => {
        get(
            'product',
            'getSkuFinalPrices',
            getPriceData(),
            'json',
            null,
            function (result) {
                insertPriceData(result);
            }
        );
    }, 200);
}


function fillPromoInfo() {
    const discount = promoSelect.selectedOptions[0].dataset.discount;
    const status = promoSelect.selectedOptions[0].dataset.status;
    const statusDescription = promoSelect.selectedOptions[0].dataset.statusHuman;

    const promoInfoCont = document.querySelector('#promoInfo');
    const promoDiscount = document.querySelector('#promoDiscount');
    const promoStatus = document.querySelector('#promoStatus');

    if (promoSelect.value) {
        promoInfoCont.classList.remove('hidden');
        promoDiscount.innerText = discount + '%';
        promoStatus.innerText = statusDescription;

        status === 'scheduled'
            ? promoStatus.classList.add('text-scheduled')
            : promoStatus.classList.remove('text-scheduled');
    } else {
        promoDiscount.innerText = '';
        promoStatus.innerText = '';
        promoStatus.classList.remove('text-scheduled');
        promoInfoCont.classList.add('hidden');
    }
}


function updateImageList() {
    const imageListInput = document.querySelector('#skuImages');
    const imageItems = imagesCont.querySelectorAll('.sku-edit_image-item');
    let imgArr = [];

    imageItems.forEach(item => imgArr.push(item.dataset.id));

    imageListInput.value = JSON.stringify(imgArr);
}

function activateImageSubmitBtn() {
    const btn = document.querySelector('#newImageSubmitBtn');

    if (btn.disabled) {
        btn.classList.remove('btn-inactive');
        btn.disabled = false;
    }
}


function updateSpec(sku_id, specForm) {
    const spec_id = specForm.dataset.specId;
    const specFormData = new FormData(specForm);
    const fields = Object.fromEntries(specFormData.entries());
    const args = {sku_id, spec_id, fields};

    post(
        'product',
        'updateSkuSpec',
        args,
        function (result) {
            showFieldErrors(specForm, result.errors);
        },
        function (result) {
            showClientModal({
                icon: 'success',
                message: result.message,
            });
        }
    );
}


function deleteSpec(sku_id, specForm) {
    const spec_id = specForm.dataset.specId;
    const args = {sku_id, spec_id};

    post(
        'product',
        'deleteSkuSpec',
        args,
        null,
        function (result) {
            showClientModal({
                icon: 'success',
                message: result.message,
            });
        }
    );
}


function isClearedSpec(specForm) {
    let is_deleting = true;
    const textAreas = specForm.querySelectorAll('textarea');

    textAreas.forEach(tArea => {
        if (tArea.value) is_deleting = false;
    });

    return is_deleting;
}


function getSpecTAreaByFieldName(specForm, fieldName) {
    const lang = fieldName.split('.').pop();

    return specForm.querySelector(`textarea[name=${lang}]`);
}
