import $ from 'jquery';

const fadeSpeed = 100;
let dropdownOpened = false;

function openDropdown(dropdown_btn) {
    if (dropdownOpened) closeAllDropdowns();
    $(dropdown_btn).siblings('.dropdown-list').first().fadeIn(fadeSpeed);
    $(dropdown_btn).data('opened', true);
    dropdownOpened = true;
    $(document).on('click', closeOnClickOutside);
}

function closeDropdown(dropdown_btn) {
    $(dropdown_btn).siblings('.dropdown-list').first().fadeOut(fadeSpeed);
    $(dropdown_btn).data('opened', false);
    $(document).off('click', closeOnClickOutside);
}

function closeAllDropdowns() {
    $('.dropdown-btn').each(function () {
        if ($(this).data('opened')) {
            closeDropdown($(this));
        }
    })
    dropdownOpened = false;
}

function closeOnClickOutside(event) {
    if(dropdownOpened && !$(event.target).closest('.dropdown-btn, .dropdown-list').length) {
        closeAllDropdowns();
    }
}

export default function init() {
    $('.dropdown-btn').on('click', function() {
        $(this).data('opened') ? closeAllDropdowns() : openDropdown($(this));
    });
}

export function languageDropdown() {
    $('.lang-menu a').on('click', function(e) {
        let $checkIcon = $(e.target).parents('.dropdown-list').find('.icon-check-lg');
        $checkIcon.clone().appendTo(e.target).addClass('va2');
        $checkIcon.remove();
    });
}