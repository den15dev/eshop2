$(document).ready(function () {

    /* -------------- Catalog navigation -------------- */

    let catalogNavOpened = false;
    const fadeSpeed = 150;

    function toggleCatalogNav() {
        $('#catalogNavCont, .catalog-nav-tint').fadeToggle(fadeSpeed);
        $('#desktopHeader .svg-catalog-list').fadeToggle(fadeSpeed);
        $('#desktopHeader .svg-close').fadeToggle(fadeSpeed);
        $('#mobileHeader .svg-chevron-down').fadeToggle(fadeSpeed);
        $('#mobileHeader .svg-close').fadeToggle(fadeSpeed);
        catalogNavOpened = !catalogNavOpened;
    }

    $('#catalogBtnDesktop').on('click', toggleCatalogNav)
    $('#catalogBtnMobile').on('click', toggleCatalogNav);

    // Hide on click outside
    $(document).on("click", function(event){
        if(catalogNavOpened && !$(event.target).closest("#catalogNavCont, #catalogBtnDesktop, #catalogBtnMobile").length){
            $('#catalogNavCont, .catalog-nav-tint').fadeOut(fadeSpeed);
            $('#desktopHeader .svg-close').fadeOut(fadeSpeed);
            $('#desktopHeader .svg-catalog-list').fadeIn(fadeSpeed);
            $('#mobileHeader .svg-close').fadeOut(fadeSpeed);
            $('#mobileHeader .svg-chevron-down').fadeIn(fadeSpeed);
            catalogNavOpened = false;
        }
    });

});