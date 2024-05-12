import { showErrorMessage } from "../../common/modals.js";
import { csrf, getCookieValue, lang, translations } from "../../common/global.js";

const favBtns = document.querySelectorAll('.product-favorite-btn');
const favMenuBtns = document.querySelectorAll('#favoritesBtnDesktop, #favoritesBtnMobile');
const cookieName = 'fav';


export default function init() {
    favBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const sku_id = btn.dataset.id;
            sendData(sku_id);
        });
    });
}


function sendData(sku_id) {
    fetch(`/${lang}/favorites`, {
        method: 'post',
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({
            id: sku_id,
        }),
    })
    .then(response => {
        if (!response.ok) {
            const error = new Error();
            error.status = response.status;
            error.statusText = response.statusText;
            throw error;
        }
        return response.json();
    })
    .then(result => {
        const favNum = result.auth ? result.num : updateList(sku_id);

        toggleButtons(sku_id);
        updateBadges(favNum);

        // Reload the page if we are on the Favorites page
        if (window.location.pathname.match(/favorites\/?$/)) {
            window.location.reload();
        }
    })
    .catch(err => showErrorMessage(err));
}


function updateList(sku_id) {
    sku_id = parseInt(sku_id, 10);
    let favoritesArr = getFavoritesArray();

    if (favoritesArr) {
        if (favoritesArr.includes(sku_id)) {
            favoritesArr = favoritesArr.filter(id => {
                return id !== sku_id;
            });

        } else {
            favoritesArr.push(sku_id);
        }

    } else {
        favoritesArr = [sku_id];
    }

    if (favoritesArr.length) {
        setCookie(favoritesArr);
    } else {
        removeCookie();
    }

    return favoritesArr.length;
}


function getFavoritesArray() {
    const favoritesCookie = getCookieValue(cookieName);
    return favoritesCookie ? JSON.parse(decodeURIComponent(favoritesCookie)) : null;
}

export function setCookie(favoritesArr) {
    document.cookie = cookieName + '=' + encodeURIComponent(JSON.stringify(favoritesArr)) + '; path=/; max-age=2592000';
}

export function removeCookie() {
    document.cookie = cookieName + '=; path=/; max-age=-1';
}


function toggleButtons(sku_id) {
    const btns = document.querySelectorAll(`.product-favorite-btn[data-id="${sku_id}"]`);

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