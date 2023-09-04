/* ---------------- Main ------------------ */

let smMedia = window.matchMedia('(min-width: 576px)');
let lgMedia = window.matchMedia('(min-width: 992px)');


/* -------------- Navigation -------------- */

const fadeSpeed = 100;
const catalogFadeSpeed = 100;
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


    // -------- Catalog desktop ---------
    const catalogRootList = $('.catalog-desktop-root-list').first();
    const bodyConts = $('#catalogNavDesktop .catalog-desktop-body-cont');
    let catalogMenuTimeout;
    let currentId = 1;

    // Set container height
    /*
    const catalogNavCont = $('#catalogNavCont');
    const catalogNavDesktop = $('#catalogNavDesktop');
    $(catalogNavCont).css('display', 'block');
    let catalogDesktopBodyMaxHeight = $(catalogNavDesktop).innerHeight();
    $(bodyConts).first().css('display', 'none');
    $(bodyConts).each(function(ind, bodyCont) {
        let curHeight = catalogDesktopBodyMaxHeight;
        if (ind > 0) {
            $(bodyCont).css('display', 'block');
            curHeight = $(catalogNavDesktop).innerHeight();
            if (curHeight > catalogDesktopBodyMaxHeight) {
                catalogDesktopBodyMaxHeight = curHeight;
            }
            $(bodyCont).css('display', 'none');
        }
    });
    $(bodyConts).first().css('display', 'block');
    $(catalogNavDesktop).css('height', `${catalogDesktopBodyMaxHeight}px`);
    $(catalogNavCont).css('display', 'none');
     */


    // --- Root List ---
    /*
    $(catalogRootList).children('li').on('mouseenter', function() {
        catalogMenuTimeout = setTimeout(() => {
            const newLiElem = $(this);
            const newCatId = $(newLiElem).data('id');
            currentId = newCatId;
            const currentOpenedBody = $(bodyConts).filter(function() {
                return $(this).data('opened') === 'on';
            });
            const currentOpenedId = $(currentOpenedBody).data('id');

            if (typeof currentOpenedId === 'number' && currentOpenedId !== newCatId) {
                const catalogNavDesktop = $('#catalogNavDesktop');
                const targetBody = $(bodyConts).filter('[data-id="' + newCatId + '"]');

                if (targetBody.length) {
                    $(catalogNavDesktop).css('height', 'auto');
                    const h1 = $(catalogNavDesktop).innerHeight();

                    $(currentOpenedBody).fadeOut(catalogFadeSpeed, function () {
                        $(currentOpenedBody).data('opened', 'off');

                        if (currentId === newCatId) {
                            $(targetBody).fadeIn(catalogFadeSpeed);
                            $(targetBody).data('opened', 'on');

                            // Animate height of the catalog menu
                            const h2 = $(catalogNavDesktop).innerHeight();
                            $(catalogNavDesktop).css('height', `${h1}px`);
                            $(catalogNavDesktop).animate({height: h2}, 200);

                            // Make button active
                            $(newLiElem).addClass('active');
                        }
                    });

                    // Make old button inactive
                    const oldLiElem = $(catalogRootList).children('li').filter('[data-id="' + currentOpenedId + '"]');
                    $(oldLiElem).removeClass('active');
                }
            }
        }, 250);
    });

     */


    // --- Root List 2 ---
    $(catalogRootList).children('li').on('mouseenter', function() {
        catalogMenuTimeout = setTimeout(() => {
            const newLiElem = $(this);
            const newCatId = $(newLiElem).data('id');
            currentId = newCatId;
            const currentOpenedBody = $(bodyConts).filter(function() {
                return $(this).data('opened') === 'on';
            });
            const currentOpenedId = $(currentOpenedBody).data('id');

            if (typeof currentOpenedId === 'number' && currentOpenedId !== newCatId) {
                const catalogNavDesktop = $('#catalogNavDesktop');
                const targetBody = $(bodyConts).filter('[data-id="' + newCatId + '"]');

                if (targetBody.length) {
                    /*
                    $(catalogNavDesktop).css('height', 'auto');
                    const h1 = $(catalogNavDesktop).innerHeight();

                    $(currentOpenedBody).fadeOut(catalogFadeSpeed, function () {
                        $(currentOpenedBody).data('opened', 'off');

                        if (currentId === newCatId) {
                            $(targetBody).fadeIn(catalogFadeSpeed);
                            $(targetBody).data('opened', 'on');

                            // Animate height of the catalog menu
                            const h2 = $(catalogNavDesktop).innerHeight();
                            $(catalogNavDesktop).css('height', `${h1}px`);
                            $(catalogNavDesktop).animate({height: h2}, 200);

                            // Make button active
                            $(newLiElem).addClass('active');
                        }
                    });
                    */

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

    /*
    // --- Sub Lists ---
    $('.catalog-desktop_subcont .catalog-desktop-sublist:first-child li').children('div, a').on('mouseenter', function() {
        catalogMenuTimeout = setTimeout(() => {
            const itemBtn = $(this);
            const newSubCatId = $(itemBtn).parent().data('id');
            currentId = newSubCatId;

            const currentSubCont = $(itemBtn).parents('div.catalog-desktop_subcont').first();
            const subLists = $(currentSubCont).children('.catalog-desktop-sublist');
            const targetSubList = subLists.filter('[data-id="' + newSubCatId + '"]');

            //Get current opened items
            const currentOpenedSublist = $(subLists).filter(function() {
                return $(this).data('opened') === 'on';
            });
            const currentOpenedId = $(currentOpenedSublist).data('id');
            const oldItemBtn = subLists.first().children('li').filter('[data-id="' + currentOpenedId + '"]');


            if (newSubCatId !== currentOpenedId) {

                if (targetSubList.length) {

                    if (typeof currentOpenedId === 'number') {
                        $(currentOpenedSublist).fadeOut(catalogFadeSpeed, function() {

                            $(targetSubList).fadeIn(catalogFadeSpeed);
                            $(targetSubList).data('opened', 'on');

                        });
                        $(currentOpenedSublist).data('opened', 'off');

                    } else {
                        $(targetSubList).fadeIn(catalogFadeSpeed);
                        $(targetSubList).data('opened', 'on');
                    }

                } else {

                    if (typeof currentOpenedId === 'number') {
                        $(currentOpenedSublist).fadeOut(catalogFadeSpeed);
                        $(currentOpenedSublist).data('opened', 'off');
                    }

                }

            }

            $(oldItemBtn).removeClass('active');
            $(itemBtn).addClass('active');


        }, 250);
    });
*/

    // --- Section dropdowns ---
    let catalogDDTimeout;
    const hoverDropdowns = $('.dropdown-hover');

    function closeDesktopCatalogDropdowns(bodyCont) {
        $(bodyCont).find('.dropdown-hover').each(function() {
            if ($(this).data('opened') === 'on') {
                // $(this).children('.dropdown-list').first().fadeOut(fadeSpeed);
                $(this).children('.dropdown-list').first().hide();
            }
        });
    }

    $(hoverDropdowns).on('mouseenter', function() {
        clearTimeout(catalogDDTimeout);
        catalogDDTimeout = setTimeout(() => {
            // Close other
            $(this).data('opened', 'off');
            closeDesktopCatalogDropdowns($(this).parents('.catalog-desktop-body-cont'));

            // $(this).children('.dropdown-list').first().fadeIn(fadeSpeed);
            $(this).children('.dropdown-list').first().show();
            $(this).data('opened', 'on');
        }, 200);
    });

    $(hoverDropdowns).on('mouseleave', function() {
        clearTimeout(catalogDDTimeout);
        catalogDDTimeout = setTimeout(() => {
            /*
            $(this).children('.dropdown-list').first().fadeOut(fadeSpeed, function() {
                closeDesktopCatalogDropdowns($(this).parents('.catalog-desktop-body-cont'));
            });
            */
            $(this).children('.dropdown-list').first().hide();
            closeDesktopCatalogDropdowns($(this).parents('.catalog-desktop-body-cont'));

            $(this).data('opened', 'off');
        }, 200);
    });
});