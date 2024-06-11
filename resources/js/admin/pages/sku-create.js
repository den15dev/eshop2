const skuCreateForm = document.querySelector('#skuCreateForm');
let imageIndex;

export default function init() {
    if (skuCreateForm) {
        const addImageBtn = document.querySelector('#addImageBtn');
        imageIndex = 2;

        addImageBtn.addEventListener('click', () => {
            addImageInput(addImageBtn);
        });

        skuCreateForm.addEventListener('submit', e => {
            e.preventDefault();
            disableEmptySpecs();
            skuCreateForm.submit();
        });
    }
}


function addImageInput(addImageBtn) {
    const imageCont = addImageBtn.parentNode.querySelector('.create-sku_image');
    const newImageCont = imageCont.cloneNode(true);
    const newFileInput = newImageCont.querySelector('input');
    const indexStr = imageIndex > 9 ? imageIndex : `0${imageIndex}`;

    newFileInput.name = `images[${indexStr}]`;
    newFileInput.setAttribute('id', `skuNewImage_${indexStr}`);
    newFileInput.value = '';

    addImageBtn.insertAdjacentElement('beforebegin', newImageCont);
    imageIndex++;
}


function disableEmptySpecs() {
    const specItems = document.querySelectorAll('.spec-item');

    specItems.forEach(specItem => {
        const textAreas = specItem.querySelectorAll('textarea');
        let isEmptySpec = true;

        textAreas.forEach(textArea => isEmptySpec = !textArea.value);

        if (isEmptySpec) {
            textAreas.forEach(textArea => textArea.disabled = true);
        }
    });
}