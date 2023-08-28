
/* ------------- TEMP ----------------- */

const temp_data = `
            <div class="search_results_cont_inner scrollbar-thin">
            
                <div class="search-result_count-block">
                    <span class="fw-bold">Бренды</span>
                    <span class="lightgrey-text">(1)</span>
                </div>

                <a href="http://eshop1.ru/brands/amd" class="search-result_brand-block dark-link">AMD</a>

                <div class="my-1"></div>
            
                <div class="search-result_count-block">
                    <a href="http://eshop1.ru/search?query=13900" class="dark-link">
                        <span class="fw-bold">Товары</span>
                        <span class="lightgrey-text">(18)</span>
                    </a>
                </div>

                <a href="http://eshop1.ru/catalog/cpu/processor-intel-core-i9-13900-8" class="search-result_block">
                    <img src="storage/images/products/1/01_80.jpg">
                    <div class="product-title">
                        Процессор Intel Core i9-13900
                    </div>
                    <div class="product-price">
                        69 190 ₽
                    </div>
                </a>
                <a href="http://eshop1.ru/catalog/cpu/processor-intel-core-i9-13900-23" class="search-result_block">
                    <img src="storage/images/products/2/01_80.jpg">
                    <div class="product-title">
                        Процессор Intel Core i9-13900KF BOX
                    </div>
                    <div class="product-price">
                        57 950 ₽
                    </div>
                </a>
                <a href="http://eshop1.ru/catalog/cpu/processor-intel-core-i9-13900-36" class="search-result_block">
                    <img src="storage/images/products/3/01_80.jpg">
                    <div class="product-title">
                        Процессор Intel Core i9-13900
                    </div>
                    <div class="product-price">
                        57 490 ₽
                    </div>
                </a>
                <a href="http://eshop1.ru/catalog/cpu/processor-intel-core-i9-13900-40" class="search-result_block">
                    <img src="storage/images/products/1/01_80.jpg">
                    <div class="product-title">
                        Процессор Intel Core i9-13900
                    </div>
                    <div class="product-price">
                        55 590 ₽
                    </div>
                </a>
                
                <a href="http://eshop1.ru/catalog/cpu/processor-intel-core-i9-13900-23" class="search-result_block">
                    <img src="storage/images/products/2/01_80.jpg">
                    <div class="product-title">
                        Процессор Intel Core i9-13900KF BOX
                    </div>
                    <div class="product-price">
                        57 950 ₽
                    </div>
                </a>
                <a href="http://eshop1.ru/catalog/cpu/processor-intel-core-i9-13900-36" class="search-result_block">
                    <img src="storage/images/products/3/01_80.jpg">
                    <div class="product-title">
                        Процессор Intel Core i9-13900
                    </div>
                    <div class="product-price">
                        57 490 ₽
                    </div>
                </a>
            </div>
`;

/* ------------------------------------ */


let searchResCont;
let searchInput;
let clearBtn;
let searchInputTimeOut;

switchSearchInput(lgMedia);
lgMedia.addEventListener('change', switchSearchInput);

function switchSearchInput(mediaQuery) {
    if (mediaQuery.matches) {
        closeAllMobileMenus();
        searchResCont = document.getElementById('searchResultCont');
        searchInput = document.getElementById('searchInput');
        clearBtn = document.getElementById('clearBtn');
        clearSearchResults();
        // On a desktop only: hide search result on input blur.
        searchInput.onblur = hideSearchResults;
    } else {
        searchResCont = document.getElementById('searchResultContMobile');
        searchInput = document.getElementById('searchInputMobile');
        clearBtn = document.getElementById('clearBtnMobile');
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
    /*
    $.ajax({
        url: '/search/autocomplete',
        method: 'get',
        dataType: 'text',
        data: {query: query_str},
        success: function(data){
            showSearchResults(data);
        }
    });
    */

    showSearchResults(temp_data);
}

function showSearchResults(results) {
    searchInput.classList.remove('bordered');
    searchResCont.style.display = 'block';
    searchResCont.innerHTML = results;
    clearBtn.style.display = 'block';

    searchResCont.onmouseover = () => searchInput.onblur = null;
    searchResCont.onmouseout = () => searchInput.onblur = hideSearchResults;

    if (!lgMedia.matches) {
        setMobileSearchResContHeight();
        $(window).on('resize', setMobileSearchResContHeight);
    }
}

function setMobileSearchResContHeight() {
    const bottomNavContHeight = $('.bottom-nav_cont').first().innerHeight();
    const mobileHeaderHeight = $('#mobileHeader').innerHeight();
    const searchInputHeight = $('#searchMobileCont').children('div.container').first().innerHeight();
    const searchResultMarginTop = parseInt($('#searchResultContMobile').css('margin-top'), 10);

    const maxHeight = `${window.innerHeight - bottomNavContHeight - mobileHeaderHeight - searchInputHeight - searchResultMarginTop - 8}px`;
    $('#searchResultContMobile .search_results_cont_inner').first().css('max-height', maxHeight);
}

function hideSearchResults() {
    searchResCont.style.display = 'none';
    searchInput.classList.add('bordered');
    $(window).off('resize', setMobileSearchResContHeight);
}

function clearSearchResults() {
    searchInput.value = '';
    searchResCont.innerHTML = '';
    searchResCont.style.display = 'none';
    searchInput.classList.add('bordered');

    searchResCont.onmouseover = null;
    searchResCont.onmouseout = null;

    clearBtn.style.display = 'none';
    searchInput.focus();
    $(window).off('resize', setMobileSearchResContHeight);
}
