export const popup = document.querySelector('.comparison-popup');
export const compareBtns = document.querySelectorAll('.product-compare-btn');

export const slideSpeed = 50;
export const fadeSpeed = 300;

export let popupBody;
export function setPopupBody(pBody) {
    popupBody = pBody;
}