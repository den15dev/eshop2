/* -------------- Main navigation -------------- */

const fadeSpeed = 150;
let catalogNavOpened = false;
let mobileSearchOpened = false;
let bottomNavMenuOpened = false;
let bottomNavProfileOpened = false;
let bottomNavLangOpened = false;

function toggleCatalogNav(holdTint = false) {
    holdTint = closeOthersHoldingTint('catalogNav') ?? holdTint;

    $('#catalogNavCont').fadeToggle(fadeSpeed);
    if (!holdTint) { $('.main-tint').fadeToggle(fadeSpeed); }

    $('#catalogBtnDesktop .svg-catalog-list').fadeToggle(fadeSpeed);
    $('#catalogBtnDesktop .svg-close').fadeToggle(fadeSpeed);
    $('#catalogBtnMobile .svg-chevron-down').fadeToggle(fadeSpeed);
    $('#catalogBtnMobile .svg-close').fadeToggle(fadeSpeed);
    catalogNavOpened = !catalogNavOpened;
}

function closeCatalogNav() {
    if (catalogNavOpened) {
        $('#catalogNavCont, .main-tint').fadeOut(fadeSpeed);
        $('#catalogBtnDesktop .svg-close').fadeOut(fadeSpeed);
        $('#catalogBtnDesktop .svg-catalog-list').fadeIn(fadeSpeed);
        $('#catalogBtnMobile .svg-close').fadeOut(fadeSpeed);
        $('#catalogBtnMobile .svg-chevron-down').fadeIn(fadeSpeed);
        catalogNavOpened = false;
    }
}

function toggleSearchMobile(holdTint = false) {
    holdTint = closeOthersHoldingTint('mobileSearch') ?? holdTint;

    $('#searchMobileCont').fadeToggle(fadeSpeed);
    if (!holdTint) $('.main-tint').fadeToggle(fadeSpeed);

    $('#searchBtnMobileNav .svg-search').fadeToggle(fadeSpeed);
    $('#searchBtnMobileNav .svg-close').fadeToggle(fadeSpeed);
    mobileSearchOpened = !mobileSearchOpened;
}

function closeSearchMobile() {
    if (mobileSearchOpened) {
        $('#searchMobileCont, .main-tint').fadeOut(fadeSpeed);
        $('#searchBtnMobileNav .svg-search').fadeIn(fadeSpeed);
        $('#searchBtnMobileNav .svg-close').fadeOut(fadeSpeed);
        mobileSearchOpened = false;
    }
}

function toggleBottomNavMenu(holdTint = false) {
    holdTint = closeOthersHoldingTint('bottomNavMenu') ?? holdTint;

    $('#bottomNavMenuCont').fadeToggle(fadeSpeed);
    $('#bottomNavMenuBtn').toggleClass('active');
    if (!holdTint) $('.main-tint').fadeToggle(fadeSpeed);
    bottomNavMenuOpened = !bottomNavMenuOpened;
}

function closeBottomNavMenu() {
    if (bottomNavMenuOpened) {
        $('#bottomNavMenuCont, .main-tint').fadeOut(fadeSpeed);
        $('#bottomNavMenuBtn').removeClass('active');
        bottomNavMenuOpened = false;
    }
}

function toggleBottomNavProfile(holdTint = false) {
    holdTint = closeOthersHoldingTint('bottomNavProfile') ?? holdTint;

    $('#bottomNavProfileCont').fadeToggle(fadeSpeed);
    $('#bottomNavProfileBtn').toggleClass('active');
    if (!holdTint) $('.main-tint').fadeToggle(fadeSpeed);
    bottomNavProfileOpened = !bottomNavProfileOpened;
}

function closeBottomNavProfile() {
    if (bottomNavProfileOpened) {
        $('#bottomNavProfileCont, .main-tint').fadeOut(fadeSpeed);
        $('#bottomNavProfileBtn').removeClass('active');
        bottomNavProfileOpened = false;
    }
}

function toggleBottomNavLangMenu() {
    $('#bottomLangMenu').fadeToggle(fadeSpeed);
    // Move the check icon
    if (!bottomNavLangOpened) {
        $('#bottomLangMenu a').on('click', function (e) {
            let $checkIcon = $('#bottomLangMenu .icon-check-lg');
            $checkIcon.clone().appendTo(e.target).addClass('va2');
            $checkIcon.remove();
        });
        $('#bottomLangCurrentBtn').on('click', closeBottomNavLangMenu);
    }
    bottomNavLangOpened = !bottomNavLangOpened;
}

function closeBottomNavLangMenu() {
    $('#bottomLangMenu').fadeOut(fadeSpeed);
    bottomNavLangOpened = false;
}

function closeOthersHoldingTint(currentMenu) {
    let somethingWasOpened = null;

    if (currentMenu !== 'mobileSearch' && mobileSearchOpened) {
        toggleSearchMobile(true);
        somethingWasOpened = true;
    }
    if (currentMenu !== 'catalogNav' && catalogNavOpened) {
        toggleCatalogNav(true);
        somethingWasOpened = true;
    }
    if (currentMenu !== 'bottomNavMenu' && bottomNavMenuOpened) {
        toggleBottomNavMenu(true);
        somethingWasOpened = true;
    }
    if (currentMenu !== 'bottomNavProfile' && bottomNavProfileOpened) {
        toggleBottomNavProfile(true);
        somethingWasOpened = true;
    }

    return somethingWasOpened;
}

function closeAllMobileMenus() {
    closeSearchMobile();
    closeBottomNavMenu();
    closeBottomNavProfile();
}


// Hide on click outside
$(document).on("click", function(event){
    if(catalogNavOpened && !$(event.target).closest("#catalogNavCont, #catalogBtnDesktop, #catalogBtnMobile").length) {
        closeCatalogNav();
    }
    if(mobileSearchOpened && !$(event.target).closest("#searchMobileCont, #searchBtnMobileNav").length) {
        closeSearchMobile();
    }
    if(bottomNavMenuOpened && !$(event.target).closest("#bottomNavMenuCont, #bottomNavMenuBtn").length) {
        closeBottomNavMenu();
    }
    if(bottomNavProfileOpened && !$(event.target).closest("#bottomNavProfileCont, #bottomNavProfileBtn").length) {
        closeBottomNavProfile();
    }
    if(bottomNavLangOpened && !$(event.target).closest("#bottomLangMenu, #bottomMenuLangBtn").length) {
        closeBottomNavLangMenu();
    }
});


$(document).ready(function () {
    $('#catalogBtnDesktop').on('click', function () { toggleCatalogNav(); });
    $('#catalogBtnMobile').on('click', function () { toggleCatalogNav(); });
    $('#searchBtnMobileNav').on('click', function () { toggleSearchMobile(); });
    $('#bottomNavMenuBtn').on('click', function () { toggleBottomNavMenu(); });
    $('#bottomMenuCloseBtn').on('click', function () { closeBottomNavMenu(); });
    $('#bottomNavProfileBtn').on('click', function () { toggleBottomNavProfile(); });
    $('#bottomMenuProfileCloseBtn').on('click', function () { closeBottomNavProfile(); });
    $('#bottomMenuLangBtn').on('click', function () { toggleBottomNavLangMenu(); });
});