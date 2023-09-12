/* ---------------- Main ------------------ */

let smMedia = window.matchMedia('(min-width: 576px)');
let lgMedia = window.matchMedia('(min-width: 992px)');

/* -------------- Navigation -------------- */
/*
const fadeSpeed = 100;
const slideSpeed = 100;
let htmlElem = $('html');

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
*/


/* ----------- Toggle scroll on a mobile ----------- */
/*
function disableScroll() {
    if (!lgMedia.matches && $(document).height() > $(window).height()) {
        $(htmlElem).addClass('noscroll-mobile');
    }
}

function enableScroll() {
    $(htmlElem).removeClass('noscroll-mobile');
    $(htmlElem).removeAttr('class');
}

function toggleScroll() {
    $(htmlElem).hasClass('noscroll-mobile') ? enableScroll() : disableScroll();
}
*/

/* ----------- Dropdowns --------------- */
/*
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
*/

/* ---------- Catalog mobile ---------- */
/*
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
*/
/* ------------------------------------ */


// Hide on click outside
/*
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
*/

/*
// Close all mobile menus on screen change to desktop
lgMedia.addEventListener('change', () => {
    if (lgMedia.matches) {
        closeSearchMobile();
        closeBottomNavMenu();
        closeBottomNavProfile();
        enableScroll();
    }
});
*/




// ------- Header --------
/*
$('#catalogBtnDesktop').on('click', function() { toggleCatalogNav(); });
$('#catalogBtnMobile').on('click', function() { toggleCatalogNav(); });
$('#searchBtnMobileNav').on('click', function() { toggleSearchMobile(); });

// ------ Mobile bottom navigation --------
$('#bottomNavMenuBtn').on('click', function() { toggleBottomNavMenu(); });
$('#bottomMenuCloseBtn').on('click', function() { closeBottomNavMenu(); });
$('#bottomNavProfileBtn').on('click', function() { toggleBottomNavProfile(); });
$('#bottomMenuProfileCloseBtn').on('click', function() { closeBottomNavProfile(); });
*/

/*
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
*/

/*
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
*/


// -------- Catalog desktop ---------
/*
const catalogRootList = $('.catalog-desktop-root-list').first();
const bodyConts = $('#catalogNavDesktop .catalog-desktop-body-cont');
let catalogMenuTimeout;

// --- Root List ---
$(catalogRootList).children('li').on('mouseenter', function() {
    catalogMenuTimeout = setTimeout(() => {
        const newLiElem = $(this);
        const newCatId = $(newLiElem).data('id');
        const currentOpenedBody = $(bodyConts).filter(function() {
            return $(this).data('opened') === 'on';
        });
        const currentOpenedId = $(currentOpenedBody).data('id');

        if (typeof currentOpenedId === 'number' && currentOpenedId !== newCatId) {
            const catalogNavDesktop = $('#catalogNavDesktop');
            const targetBody = $(bodyConts).filter('[data-id="' + newCatId + '"]');

            if (targetBody.length) {
                $(catalogNavDesktop).css('height', 'auto');

                $(currentOpenedBody).hide();
                $(currentOpenedBody).data('opened', 'off');

                $(targetBody).show();
                $(targetBody).data('opened', 'on');

                const h1 = $(catalogNavDesktop).innerHeight();
                $(catalogNavDesktop).css('height', `${h1}px`);

                $(newLiElem).addClass('active');

                // Make old button inactive
                const oldLiElem = $(catalogRootList).children('li').filter('[data-id="' + currentOpenedId + '"]');
                $(oldLiElem).removeClass('active');
            }
        }
    }, 250);
});


$(catalogRootList).children('li').on('mouseleave', function() {
    clearTimeout(catalogMenuTimeout);
});


// --- Section dropdowns ---
let catalogDDTimeout;
const hoverDropdowns = $('.dropdown-hover');

function closeSubCategoryDropdowns(bodyCont) {
    $(bodyCont).find('.dropdown-hover').each(function() {
        if ($(this).data('opened') === 'on') {
            $(this).children('.dropdown-list').first().hide();
        }
    });
}

$(hoverDropdowns).on('mouseenter', function() {
    clearTimeout(catalogDDTimeout);
    catalogDDTimeout = setTimeout(() => {
        // Close other
        $(this).data('opened', 'off');
        closeSubCategoryDropdowns($(this).parents('.catalog-desktop-body-cont'));

        $(this).children('.dropdown-list').first().show();
        $(this).data('opened', 'on');
    }, 200);
});

$(hoverDropdowns).on('mouseleave', function() {
    clearTimeout(catalogDDTimeout);
    catalogDDTimeout = setTimeout(() => {
        $(this).children('.dropdown-list').first().hide();
        closeSubCategoryDropdowns($(this).parents('.catalog-desktop-body-cont'));

        $(this).data('opened', 'off');
    }, 200);
});

*/


// ==========================================================
// ==========================================================


/*
function toggleMenuOpener(opener, options) {
    if (opener.isOpened) {
        closeOpener(opener, options);
        options.tint.fadeOut(options.fadeSpeed);
        enableScroll();
        $(document).off('click', closeOnClickOutside);

    } else {
        menuOpeners.forEach(prevOpener => {
            if (prevOpener.isOpened) {
                closeOpener(prevOpener, options);
            }
        })

        options.tint.fadeIn(options.fadeSpeed);
        opener.container.fadeIn(options.fadeSpeed);
        opener.open();
        opener.isOpened = true;
        disableScroll();
        $(document).on('click', closeOnClickOutside);
    }
}


function closeOpener(opener, options) {
    opener.container.fadeOut(options.fadeSpeed);
    opener.close();
    opener.isOpened = false;
}


function closeOnClickOutside(event) {
    menuOpeners.forEach(opener => {
        if (opener.isOpened) {
            let elemArr = [opener.container];
            Array.isArray(opener.button) ? opener.button.forEach(elem => elemArr.push(elem)) : elemArr.push(opener.button);

            let parents = false;
            elemArr.forEach(elem => {
                if (!parents && $(event.target).closest($(elem)).length) {
                    parents = true;
                }
            });

            if (!parents) {
                const options = {
                    fadeSpeed: fadeSpeed,
                    tint: $(pageTint)
                };
                toggleMenuOpener(opener, options);
            }
        }
    });
}


const pageTint = $('.main-tint');

const menuOpeners = [
    {
        button: [$('#catalogBtnDesktop'), $('#catalogBtnMobile')],
        container: $('#catalogNavCont'),
        open() {
            $('#catalogBtnDesktop .svg-catalog-list').fadeOut(fadeSpeed);
            $('#catalogBtnDesktop .svg-close').fadeIn(fadeSpeed);
            $('#catalogBtnMobile .svg-chevron-down').fadeOut(fadeSpeed);
            $('#catalogBtnMobile .svg-close').fadeIn(fadeSpeed);
        },
        close() {
            $('#catalogBtnDesktop .svg-catalog-list').fadeIn(fadeSpeed);
            $('#catalogBtnDesktop .svg-close').fadeOut(fadeSpeed);
            $('#catalogBtnMobile .svg-chevron-down').fadeIn(fadeSpeed);
            $('#catalogBtnMobile .svg-close').fadeOut(fadeSpeed);
            catalogMobileReset();
        },
        closeButton: null,
        isOpened: false
    },

    {
        button: $('#searchBtnMobileNav'),
        container: $('#searchMobileCont'),
        open() {
            $('#searchBtnMobileNav .svg-search').fadeOut(fadeSpeed);
            $('#searchBtnMobileNav .svg-close').fadeIn(fadeSpeed);
            $('#searchInputMobile').focus();
        },
        close() {
            $('#searchBtnMobileNav .svg-search').fadeIn(fadeSpeed);
            $('#searchBtnMobileNav .svg-close').fadeOut(fadeSpeed);
        },
        closeButton: null,
        isOpened: false
    },

    {
        button: $('#bottomNavMenuBtn'),
        container: $('#bottomNavMenuCont'),
        open() {
            $('#bottomNavMenuBtn').addClass('active');
        },
        close() {
            $('#bottomNavMenuBtn').removeClass('active');
        },
        closeButton: $('#bottomMenuCloseBtn'),
        isOpened: false
    },

    {
        button: $('#bottomNavProfileBtn'),
        container: $('#bottomNavProfileCont'),
        open() {
            $('#bottomNavProfileBtn').addClass('active');
        },
        close() {
            $('#bottomNavProfileBtn').removeClass('active');
        },
        closeButton: $('#bottomMenuProfileCloseBtn'),
        isOpened: false
    }
];


menuOpeners.forEach(opener => {
    const btnArray = Array.isArray(opener.button) ? opener.button : [opener.button];
    const options = {
        fadeSpeed: fadeSpeed,
        tint: $(pageTint)
    };
    btnArray.forEach((btn) => {
        btn.on('click', function() {
            toggleMenuOpener(opener, options);
        });
    });

    if (opener.closeButton) {
        opener.closeButton.on('click', function() {
            toggleMenuOpener(opener, options);
        });
    }
});

// Close all mobile menus on screen change to desktop
lgMedia.addEventListener('change', () => {
    if (lgMedia.matches) {

        const options = {
            fadeSpeed: fadeSpeed,
            tint: $(pageTint)
        };

        menuOpeners.forEach(opener => {
            if (opener.isOpened) {
                closeOpener(opener, options);
            }
        });
    }
});

*/