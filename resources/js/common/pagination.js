import { smMedia } from "./global.js";

const paginationUl = document.querySelector('ul.pagination');

export default function init() {
    if (paginationUl) {
        smMedia.addEventListener('change', togglePaginationSize);
    }
}


function togglePaginationSize(mediaQuery) {
    if (mediaQuery.matches) {
        paginationUl.classList.remove('pagination-sm');
    } else {
        paginationUl.classList.add('pagination-sm');
    }
}