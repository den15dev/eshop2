import { translations } from "../../../common/global.js";


export function toggleButtons(product_id) {
    const btns = document.querySelectorAll(`.product-compare-btn[data-id="${product_id}"]`);

    btns.forEach(btn => {
        const iconSpan = btn.querySelector('.compare-btn-icon');
        const textSpan = btn.querySelector('.compare-btn-text');

        if (btn.classList.contains('active')) {
            btn.classList.remove('active');
            iconSpan.classList.replace('icon-bar-chart-fill', 'icon-bar-chart');
            textSpan.innerText = translations.comparison.compare;
            btn.removeAttribute('title');
        } else {
            btn.classList.add('active');
            iconSpan.classList.replace('icon-bar-chart', 'icon-bar-chart-fill');
            textSpan.innerText = translations.comparison.in_list;
            btn.title = translations.comparison.remove_title;
        }
    });
}