import { showErrorMessage } from "../common/modals.js";
import {csrf, getCookieValue, lang, translations} from "../common/global.js";

const favBtns = document.querySelectorAll('.product-favorite-btn');
const favMenuBtns = document.querySelectorAll('#favoritesBtnDesktop, #favoritesBtnMobile');
const cookieName = 'fav';

let favoritesArr;

export default function init() {
    const favoritesCookie = getCookieValue(cookieName);
    favoritesArr = favoritesCookie ? JSON.parse(decodeURIComponent(favoritesCookie)) : null;
    
    favBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const product_id = btn.dataset.id;
            sendData(product_id);
        });
    });
}


function sendData(product_id) {
    fetch(`/${lang}/favorites`, {
        method: 'post',
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({
            id: product_id,
        }),
    })
    .then(response => {
        if (!response.ok) throw new Error(`${response.status} (${response.statusText})`);
        return response.json();
    })
    .then(result => {
        if (result.auth) {
            inverseButtons(product_id);
            updateBadges(result.num);
        } else {
            updateList(product_id);
        }
    })
    .catch(err => showErrorMessage(err.message));
}


function updateList(product_id) {
    product_id = parseInt(product_id, 10);

    if (favoritesArr) {
        if (favoritesArr.includes(product_id)) {
            favoritesArr = favoritesArr.filter(id => {
                return id !== product_id;
            });

            if (!favoritesArr.length) {
                favoritesArr = null;
            }

        } else {
            favoritesArr.push(product_id);
        }

    } else {
        favoritesArr = [product_id];
    }

    updateCookie(favoritesArr);

    if (favoritesArr) {
        inverseButtons(product_id);
        updateBadges(favoritesArr.length);
    } else {
        window.location.reload();
    }
}


function updateCookie(newFavoritesArr) {
    if (newFavoritesArr) {
        document.cookie = cookieName + '=' + encodeURIComponent(JSON.stringify(newFavoritesArr)) + '; path=/;  max-age=157680000';
    } else {
        document.cookie = cookieName + '=; path=/;  max-age=-1';
    }
}


function inverseButtons(product_id) {
    const btns = document.querySelectorAll(`.product-favorite-btn[data-id="${product_id}"]`);

    btns.forEach(btn => {
        const iconSpan = btn.querySelector('.favorite-btn-icon');
        const textSpan = btn.querySelector('.favorite-btn-text');

        if (btn.classList.contains('active')) {
            btn.classList.remove('active');
            iconSpan.classList.replace('icon-heart-fill', 'icon-heart');
            textSpan.innerText = translations.favorites.add_to_fav;
            btn.removeAttribute('title');
        } else {
            btn.classList.add('active');
            iconSpan.classList.replace('icon-heart', 'icon-heart-fill');
            textSpan.innerText = translations.favorites.in_fav;
            btn.title = translations.favorites.remove_title;
        }
    });
}


function updateBadges(num) {
    favMenuBtns.forEach(btn => {
        const badge = btn.querySelector('.badge-round');

        if (num) {
            badge.classList.add('active');
            badge.innerText = num;
        } else {
            badge.classList.remove('active');
            badge.innerText = 0;
        }
    });
}