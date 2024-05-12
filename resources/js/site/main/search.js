import { lgMedia, lang } from '../../common/global.js';
import { showErrorMessage } from "../../common/modals.js";
import { fadeIn, fadeOut } from "../../common/effects/fade.js";

let searchResCont;
let searchInput;
let clearBtn;
let searchInputTimeOut;
let searchTint;

const fadeSpeed = 200;

export default function init() {
    activateSearchInput(lgMedia);
    lgMedia.addEventListener('change', activateSearchInput);
}

function activateSearchInput(mediaQuery) {
    if (mediaQuery.matches) {
        searchResCont = document.getElementById('searchResultCont');
        searchInput = document.getElementById('searchInput');
        clearBtn = document.getElementById('clearBtn');
        searchTint = document.querySelector('.search-tint');
        clearSearchResults();
        // On a desktop only: hide search result on input blur.
        searchInput.onblur = hideSearchResults;
    } else {
        searchResCont = document.getElementById('searchResultContMobile');
        searchInput = document.getElementById('searchInputMobile');
        clearBtn = document.getElementById('clearBtnMobile');
        searchTint = null;
        clearSearchResults();
    }

    searchInput.oninput = handleSearchInput;
    searchInput.onfocus = handleSearchInput;
    clearBtn.onclick = clearSearchResults;
}

function handleSearchInput() {
    clearTimeout(searchInputTimeOut);

    let str = searchInput.value;
    if (str.length > 1) {
        searchInputTimeOut = setTimeout(function () {
            getSearchResults(str);
        }, 200);
    } else if (str.length > 0) {
        searchResCont.innerHTML = '';
        searchResCont.style.display = 'none';
        searchInput.classList.add('bordered');
        clearBtn.style.display = 'block';
    } else {
        clearSearchResults();
    }
}

function getSearchResults(query_str) {
    const queryString = new URLSearchParams({
        query: query_str,
    });

    fetch(`/${lang}/search/dropdown?${queryString}`, {
        method: 'get',
    })
    .then(response => {
        if (!response.ok) {
            const error = new Error();
            error.status = response.status;
            error.statusText = response.statusText;
            throw error;
        }
        return response.text();
    })
    .then(result => {
        showSearchResults(result);
    })
    .catch(err => showErrorMessage(err));
}

function showSearchResults(results) {
    searchInput.classList.remove('bordered');
    searchResCont.style.display = 'block';
    searchResCont.innerHTML = results;
    clearBtn.style.display = 'block';
    if (searchTint) {
        fadeIn(searchTint, fadeSpeed);
    }

    searchResCont.onmouseover = () => searchInput.onblur = null;
    searchResCont.onmouseout = () => searchInput.onblur = hideSearchResults;

    if (!lgMedia.matches) {
        setMobileSearchResContHeight();
        window.addEventListener('resize', setMobileSearchResContHeight);
    }
}

function setMobileSearchResContHeight() {
    const bottomNavContHeight = document.querySelector('.bottom-nav_cont').offsetHeight;
    const mobileHeaderHeight = document.querySelector('#mobileHeader').offsetHeight;
    const searchInputHeight = document.querySelector('#searchMobileCont div.container').offsetHeight;
    const searchResultMarginTop = parseInt(getComputedStyle(document.querySelector('#searchResultContMobile')).getPropertyValue('margin-top'), 10);

    const maxHeight = `${window.innerHeight - bottomNavContHeight - mobileHeaderHeight - searchInputHeight - searchResultMarginTop - 8}px`;
    document.querySelector('#searchResultContMobile .search-dropdown_cont-inner').style.maxHeight = maxHeight;
}

function hideSearchResults() {
    searchResCont.style.display = 'none';
    searchInput.classList.add('bordered');
    if (searchTint) {
        fadeOut(searchTint, fadeSpeed);
    }
    window.removeEventListener('resize', setMobileSearchResContHeight);
}

function clearSearchResults() {
    searchInput.value = '';
    searchResCont.innerHTML = '';
    searchResCont.style.display = 'none';
    searchInput.classList.add('bordered');
    if (searchTint) {
        fadeOut(searchTint, fadeSpeed);
    }

    searchResCont.onmouseover = null;
    searchResCont.onmouseout = null;

    clearBtn.style.display = 'none';
    searchInput.focus();
    window.removeEventListener('resize', setMobileSearchResContHeight);
}
