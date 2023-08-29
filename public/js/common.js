/* ---------------- Main ------------------ */

let smMedia = window.matchMedia('(min-width: 576px)');
let lgMedia = window.matchMedia('(min-width: 992px)');


/* -------------- Navigation -------------- */

const fadeSpeed = 100;
const slideSpeed = 100;
let htmlElem;
let catalogNavOpened = false;
let mobileSearchOpened = false;
let bottomNavMenuOpened = false;
let bottomNavProfileOpened = false;
let dropdownOpened = false;

function toggleCatalogNav(holdTint = false) {
    holdTint = closeOthersHoldingTint('catalogNav') ?? holdTint;

    $('#catalogNavCont').fadeToggle(fadeSpeed);
    if (catalogNavOpened) catalogMobileReset();
    if (!holdTint) {
        $('.main-tint').fadeToggle(fadeSpeed);
        toggleScroll();
    }

    $('#catalogBtnDesktop .svg-catalog-list').fadeToggle(fadeSpeed);
    $('#catalogBtnDesktop .svg-close').fadeToggle(fadeSpeed);
    $('#catalogBtnMobile .svg-chevron-down').fadeToggle(fadeSpeed);
    $('#catalogBtnMobile .svg-close').fadeToggle(fadeSpeed);
    catalogNavOpened = !catalogNavOpened;
}

function closeCatalogNav() {
    if (catalogNavOpened) {
        $('#catalogNavCont, .main-tint').fadeOut(fadeSpeed);
        catalogMobileReset();
        $('#catalogBtnDesktop .svg-close').fadeOut(fadeSpeed);
        $('#catalogBtnDesktop .svg-catalog-list').fadeIn(fadeSpeed);
        $('#catalogBtnMobile .svg-close').fadeOut(fadeSpeed);
        $('#catalogBtnMobile .svg-chevron-down').fadeIn(fadeSpeed);
        enableScroll();
        catalogNavOpened = false;
    }
}

function toggleSearchMobile(holdTint = false) {
    holdTint = closeOthersHoldingTint('mobileSearch') ?? holdTint;

    $('#searchMobileCont').fadeToggle(fadeSpeed);
    if (!holdTint) {
        $('.main-tint').fadeToggle(fadeSpeed);
        toggleScroll();
    }

    $('#searchBtnMobileNav .svg-search').fadeToggle(fadeSpeed);
    $('#searchBtnMobileNav .svg-close').fadeToggle(fadeSpeed);

    if (!mobileSearchOpened) {
        $('#searchInputMobile').focus();
    }

    mobileSearchOpened = !mobileSearchOpened;
}

function closeSearchMobile() {
    if (mobileSearchOpened) {
        $('#searchMobileCont, .main-tint').fadeOut(fadeSpeed);
        $('#searchBtnMobileNav .svg-search').fadeIn(fadeSpeed);
        $('#searchBtnMobileNav .svg-close').fadeOut(fadeSpeed);
        enableScroll();
        mobileSearchOpened = false;
    }
}

function toggleBottomNavMenu(holdTint = false) {
    holdTint = closeOthersHoldingTint('bottomNavMenu') ?? holdTint;

    $('#bottomNavMenuCont').fadeToggle(fadeSpeed);
    $('#bottomNavMenuBtn').toggleClass('active');
    if (!holdTint) {
        $('.main-tint').fadeToggle(fadeSpeed);
        toggleScroll();
    }
    bottomNavMenuOpened = !bottomNavMenuOpened;
}

function closeBottomNavMenu() {
    if (bottomNavMenuOpened) {
        $('#bottomNavMenuCont, .main-tint').fadeOut(fadeSpeed);
        $('#bottomNavMenuBtn').removeClass('active');
        enableScroll();
        bottomNavMenuOpened = false;
    }
}

function toggleBottomNavProfile(holdTint = false) {
    holdTint = closeOthersHoldingTint('bottomNavProfile') ?? holdTint;

    $('#bottomNavProfileCont').fadeToggle(fadeSpeed);
    $('#bottomNavProfileBtn').toggleClass('active');
    if (!holdTint) {
        $('.main-tint').fadeToggle(fadeSpeed);
        toggleScroll();
    }
    bottomNavProfileOpened = !bottomNavProfileOpened;
}

function closeBottomNavProfile() {
    if (bottomNavProfileOpened) {
        $('#bottomNavProfileCont, .main-tint').fadeOut(fadeSpeed);
        $('#bottomNavProfileBtn').removeClass('active');
        enableScroll();
        bottomNavProfileOpened = false;
    }
}

function closeOthersHoldingTint(currentMenu) {
    let somethingOpened = null;

    if (currentMenu !== 'mobileSearch' && mobileSearchOpened) {
        toggleSearchMobile(true);
        somethingOpened = true;
    }
    if (currentMenu !== 'catalogNav' && catalogNavOpened) {
        toggleCatalogNav(true);
        somethingOpened = true;
    }
    if (currentMenu !== 'bottomNavMenu' && bottomNavMenuOpened) {
        toggleBottomNavMenu(true);
        somethingOpened = true;
    }
    if (currentMenu !== 'bottomNavProfile' && bottomNavProfileOpened) {
        toggleBottomNavProfile(true);
        somethingOpened = true;
    }

    return somethingOpened;
}

function closeAllMobileMenus() {
    closeSearchMobile();
    closeBottomNavMenu();
    closeBottomNavProfile();
}


/* ----------- Toggle scroll ----------- */

function disableScroll() {
    if ($(document).height() > $(window).height()) {
        if (lgMedia.matches) {
            let scrollTop = ($(htmlElem).scrollTop()) ? $(htmlElem).scrollTop() : $('body').scrollTop();
            $(htmlElem).addClass('noscroll-desktop').css('top',-scrollTop);
        } else {
            $(htmlElem).addClass('noscroll-mobile');
        }
    }
}

function enableScroll() {
    if (lgMedia.matches) {
        let scrollTop = parseInt($(htmlElem).css('top'));
        $(htmlElem).removeClass('noscroll-desktop noscroll-mobile');
        $('html,body').scrollTop(-scrollTop);
    } else {
        $(htmlElem).removeClass('noscroll-desktop noscroll-mobile');
        $(htmlElem).removeAttr('style');
    }
}

function toggleScroll() {
    $(htmlElem).hasClass('noscroll-desktop') || $(htmlElem).hasClass('noscroll-mobile') ? enableScroll() : disableScroll();
}


/* ----------- Dropdowns --------------- */

function openDropdown(dropdown_btn) {
    if (dropdownOpened) closeAllDropdowns();
    $(dropdown_btn).siblings('.dropdown-list').first().fadeIn(fadeSpeed);
    $(dropdown_btn).data('opened', true);
    dropdownOpened = true;
}

function closeDropdown(dropdown_btn) {
    $(dropdown_btn).siblings('.dropdown-list').first().fadeOut(fadeSpeed);
    $(dropdown_btn).data('opened', false);
}

function closeAllDropdowns() {
    $('.dropdown-btn').each(function () {
        if ($(this).data('opened')) {
            closeDropdown($(this));
        }
    })
    dropdownOpened = false;
}


/* ---------- Catalog mobile ---------- */

function catalogMobileSetItemPaddings() {
    let n = 0;
    let iconGap = 8;
    let iconContWidth = 20;
    let paddingStepPx = 12;

    if (smMedia.matches) {
        iconGap = 9;
        iconContWidth = 24;
        paddingStepPx = 16;
    }

    function findChildrenList(parentList) {
        $(parentList).children('ul.catalog-mobile-sublist').each(function() {
            n++;
            $(this).children('li').each(function() {
                $(this).children('a, div').first().css('padding-left', `${16 + iconContWidth + iconGap + paddingStepPx * (n - 1)}px`);
                findChildrenList($(this));
            });
            n--;
        });
    }

    $('#catalogNavMobile .catalog-mobile-list').first().children('li').each(function() {
        findChildrenList($(this));
    });
}

function catalogMobileSetMaxHeight() {
    const bottomNavContHeight = $('.bottom-nav_cont').first().innerHeight();
    const mobileHeaderHeight = $('#mobileHeader').innerHeight();
    let catalogMobilMaxHeight = `${window.innerHeight - mobileHeaderHeight - bottomNavContHeight - 8}px`;
    $('#catalogNavMobile').css('max-height', catalogMobilMaxHeight);
}

function catalogMobileReset() {
    $('#catalogNavMobile ul.catalog-mobile-sublist').hide();
    $('#catalogNavMobile div.cat-btn1, #catalogNavMobile div.cat-btn2').each(function() {
        $(this).removeClass('active');
        $(this).children('.icon-chevron-up').removeClass('icon-chevron-up').addClass('icon-chevron-down');
    });
}

/* ------------------------------------ */


// Hide on click outside
$(document).on("click", function(event){
    // ------- Header --------
    if(catalogNavOpened && !$(event.target).closest("#catalogNavCont, #catalogBtnDesktop, #catalogBtnMobile").length) {
        closeCatalogNav();
    }
    if(mobileSearchOpened && !$(event.target).closest("#searchMobileCont, #searchBtnMobileNav").length) {
        closeSearchMobile();
    }

    // ------ Mobile bottom navigation --------
    if(bottomNavMenuOpened && !$(event.target).closest("#bottomNavMenuCont, #bottomNavMenuBtn").length) {
        closeBottomNavMenu();
    }
    if(bottomNavProfileOpened && !$(event.target).closest("#bottomNavProfileCont, #bottomNavProfileBtn").length) {
        closeBottomNavProfile();
    }

    // --- Dropdowns ---
    if(dropdownOpened && !$(event.target).closest('.dropdown-btn, .dropdown-list').length) {
        closeAllDropdowns();
    }
});


$(document).ready(function () {
    // -------- Main ---------
    htmlElem = $('html');

    // ------- Header --------
    $('#catalogBtnDesktop').on('click', function() { toggleCatalogNav(); });
    $('#catalogBtnMobile').on('click', function() { toggleCatalogNav(); });
    $('#searchBtnMobileNav').on('click', function() { toggleSearchMobile(); });

    // ------ Mobile bottom navigation --------
    $('#bottomNavMenuBtn').on('click', function() { toggleBottomNavMenu(); });
    $('#bottomMenuCloseBtn').on('click', function() { closeBottomNavMenu(); });
    $('#bottomNavProfileBtn').on('click', function() { toggleBottomNavProfile(); });
    $('#bottomMenuProfileCloseBtn').on('click', function() { closeBottomNavProfile(); });

    // ------- Dropdowns --------
    $('.dropdown-btn').on('click', function() {
        $(this).data('opened') ? closeAllDropdowns() : openDropdown($(this));
    });

    // ------- Language menu ---------
    $('.lang-menu a').on('click', function(e) {
        let $checkIcon = $(e.target).parents('.dropdown-list').find('.icon-check-lg');
        $checkIcon.clone().appendTo(e.target).addClass('va2');
        $checkIcon.remove();
    });

    // -------- Catalog mobile ----------
    catalogMobileSetItemPaddings();
    catalogMobileSetMaxHeight();
    $(window).on('resize', catalogMobileSetMaxHeight);
    smMedia.addEventListener('change', catalogMobileSetItemPaddings);

    $('#catalogNavMobile div.cat-btn1, #catalogNavMobile div.cat-btn2').on('click', function() {
        $(this).siblings('ul.catalog-mobile-sublist').first().slideToggle(slideSpeed);
        $(this).toggleClass('active');
        $(this).children('.icon-chevron-down, .icon-chevron-up').first().toggleClass(['icon-chevron-down', 'icon-chevron-up']);
    })
});