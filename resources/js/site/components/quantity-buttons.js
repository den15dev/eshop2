const qtyButtons = document.querySelectorAll('.quantity-btns');

export default function init() {
    qtyButtons.forEach(qtyBtn => {
        const plusBtn = qtyBtn.querySelector('.btn-qty-plus');
        const minusBtn = qtyBtn.querySelector('.btn-qty-minus');
        const qtyInput = qtyBtn.querySelector('input[name="qty"]');

        plusBtn.addEventListener('click', () => {
            const curNumber = parseInt(qtyInput.value);
            qtyInput.value = curNumber + 1;
        });

        minusBtn.addEventListener('click', () => {
            const curNumber = parseInt(qtyInput.value);
            if (curNumber > 1) {
                qtyInput.value = curNumber - 1;
            }
        });
    });
}