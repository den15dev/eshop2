import $ from 'jquery';

const catalogRootList = $('.catalog-desktop-root-list').first();
const bodyConts = $('#catalogNavDesktop .catalog-desktop-body-cont');
let catalogMenuTimeout;

export function catalogDesktopRoot() {
    $(catalogRootList).children('li').on('mouseenter', function () {
        catalogMenuTimeout = setTimeout(() => {
            const newLiElem = $(this);
            const newCatId = $(newLiElem).data('id');
            const currentOpenedBody = $(bodyConts).filter(function () {
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

    $(catalogRootList).children('li').on('mouseleave', function () {
        clearTimeout(catalogMenuTimeout);
    });
}


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

export function catalogDesktopDropdowns() {
    $(hoverDropdowns).on('mouseenter', function () {
        clearTimeout(catalogDDTimeout);
        catalogDDTimeout = setTimeout(() => {
            // Close other
            $(this).data('opened', 'off');
            closeSubCategoryDropdowns($(this).parents('.catalog-desktop-body-cont'));

            $(this).children('.dropdown-list').first().show();
            $(this).data('opened', 'on');
        }, 200);
    });

    $(hoverDropdowns).on('mouseleave', function () {
        clearTimeout(catalogDDTimeout);
        catalogDDTimeout = setTimeout(() => {
            $(this).children('.dropdown-list').first().hide();
            closeSubCategoryDropdowns($(this).parents('.catalog-desktop-body-cont'));

            $(this).data('opened', 'off');
        }, 200);
    });
}