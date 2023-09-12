import $ from 'jquery';
import { smMedia } from './_globals';

const slideSpeed = 100;

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

export function catalogMobileReset() {
    $('#catalogNavMobile ul.catalog-mobile-sublist').hide();
    $('#catalogNavMobile div.cat-btn1, #catalogNavMobile div.cat-btn2').each(function() {
        $(this).removeClass('active');
        $(this).children('.icon-chevron-up').removeClass('icon-chevron-up').addClass('icon-chevron-down');
    });
}

export default function init() {
    catalogMobileSetItemPaddings();
    catalogMobileSetMaxHeight();
    $(window).on('resize', catalogMobileSetMaxHeight);
    smMedia.addEventListener('change', catalogMobileSetItemPaddings);

    $('#catalogNavMobile div.cat-btn1, #catalogNavMobile div.cat-btn2').on('click', function() {
        $(this).siblings('ul.catalog-mobile-sublist').first().slideToggle(slideSpeed);
        $(this).toggleClass('active');
        $(this).children('.icon-chevron-down, .icon-chevron-up').first().toggleClass(['icon-chevron-down', 'icon-chevron-up']);
    })
}