const reviewForm = document.querySelector('.reviews-form');

export default function init() {
    if (reviewForm) {
        const rateCont = reviewForm.querySelector('ul.rate');
        const invalidCont = rateCont.parentNode.querySelector('.invalid-cont');
        const stars = rateCont.querySelectorAll('li.icon-star, li.icon-star-fill');
        const rateInput = reviewForm.querySelector('#rateInput');

        stars.forEach((starElem, index) => {
            starElem.addEventListener('click', () => {
                rate(stars, index);
                rateInput.value = index + 1;
                invalidCont.style.display = 'none';
            });
        });

        reviewForm.onsubmit = () => {
            if (!rateInput.value) {
                invalidCont.style.display = 'block';
                return false;
            }
            return true;
        };
    }
}


function rate(starElems, mark) {
    starElems.forEach((starElem, index) => {
        if (index <= mark) {
            starElem.classList.replace('icon-star', 'icon-star-fill');
        } else {
            starElem.className = 'icon-star';
        }
    });
}