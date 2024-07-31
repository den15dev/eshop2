import { lang } from "../../common/global.js";
import { closeDropdown, reInitDropdowns } from "../../common/dropdowns.js";
import { showErrorMessage } from "../../common/modals.js";
import { searchParams, setURL } from "./set-url-query.js";

export const tableCont = document.querySelector('#indexTableCont');
export const searchInput = document.querySelector('#searchInput');


export let tableName;
let searchInputTimeOut;
let clearSearchBtn;


export default function init() {
    if (tableCont) {
        tableName = tableCont.dataset.name;
        initColumnSelector();
        initPerPageSelector();
        initSortOrderBtns();
        initPaginationLinks();
    }

    if (searchInput) {
        searchInput.addEventListener('input', handleSearchInput);

        clearSearchBtn = searchInput.parentNode.querySelector('.index_search_close-btn');

        clearSearchBtn.addEventListener('click', () => {
            clearSearchInput();
            clearSearchBtn.classList.add('hidden');
        });
    }
}


function initColumnSelector() {
    const prefsCont = document.querySelector('.index-table_pref-cont');
    const colSelectorCont = prefsCont.querySelector('.column-selector');
    const cookieName = colSelectorCont.dataset.cookieName;
    const dropdownBtn = colSelectorCont.querySelector('.dropdown-btn');
    const applyBtn = colSelectorCont.querySelector('.column-selector_apply-btn');
    const cancelBtn = colSelectorCont.querySelector('.column-selector_close-btn');

    applyBtn.addEventListener('click', () => {

        const listCont = colSelectorCont.querySelector('.column-selector_list-cont');
        const itemInputs = listCont.querySelectorAll('.column-selector_item input');
        let checkedIndexes = [];

        itemInputs.forEach(input => {
            if (input.checked) {
                checkedIndexes.push(input.dataset.index);
            }
        });

        setCookie(cookieName, checkedIndexes);
        getTable();
        closeDropdown(dropdownBtn);
    });

    cancelBtn.addEventListener('click', () => {
        closeDropdown(dropdownBtn);
    });
}


function initPerPageSelector() {
    const perPageDropdown = document.querySelector('.index-table_per-page-dd');
    const itemBtns = perPageDropdown.querySelectorAll(`.dropdown-item`);

    itemBtns.forEach(itemBtnElem => {
        itemBtnElem.addEventListener('click', () => {
            if (!itemBtnElem.classList.contains('active')) {
                const perPage = parseInt(itemBtnElem.innerText, 10);
                setCookie('tbl_perpage', perPage);
                searchParams.delete('page');
                getTable();
            }

            const dropdownBtn = perPageDropdown.querySelector('.dropdown-btn');
            closeDropdown(dropdownBtn);
        });
    });
}


function initPaginationLinks() {
    const links = document.querySelectorAll('.pagination a.page-link');

    links.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const url = new URL(link.href);
            searchParams.set('page', url.searchParams.get('page'));
            getTable();
        });
    });
}


function handleSearchInput() {
    clearTimeout(searchInputTimeOut);

    let str = searchInput.value;
    searchParams.delete('page');

    if (str.length) {
        searchInputTimeOut = setTimeout(function () {
            searchParams.set('search', str);
            getTable();
        }, 300);

        clearSearchBtn.classList.remove('hidden');
    } else {
        searchParams.delete('search');
        getTable();
        clearSearchBtn.classList.add('hidden');
    }
}


function clearSearchInput() {
    searchInput.value = '';
    searchParams.delete('search');
    getTable();
    searchInput.focus();
}


function setCookie(name, value) {
    document.cookie = name + '=' + encodeURIComponent(JSON.stringify(value)) + '; path=/; max-age=157680000';
}


export function getTable() {
    fetch(`/${lang}/admin/${tableName}/table?${searchParams}`, {
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
        tableCont.innerHTML = result;

        const prefDropdownBtns = document.querySelectorAll('.column-selector .dropdown-btn, .index-table_per-page-dd .dropdown-btn');
        reInitDropdowns(prefDropdownBtns);

        initColumnSelector();
        initPerPageSelector();
        initSortOrderBtns();
        initPaginationLinks();
        setURL();
    })
    .catch(err => showErrorMessage(err));
}


function initSortOrderBtns() {
    const sortBtns = document.querySelectorAll('.index-table_head-btn');

    sortBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const column_id = btn.dataset.id;
            const curOrder = btn.dataset.sortOrder;

            if (curOrder === 'desc') {
                searchParams.delete('sort');
                searchParams.delete('order');
            } else if (curOrder === 'asc') {
                searchParams.set('sort', column_id);
                searchParams.set('order', 'desc');
            } else {
                searchParams.set('sort', column_id);
                searchParams.set('order', 'asc');
            }

            getTable();
        });
    });
}
