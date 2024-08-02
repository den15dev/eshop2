import '../../common/effects/slide.js';
import { getMobileWinHeight } from '../../common/global.js';

const slideSpeed = 100;


export default function init() {
    setContainerMaxHeight();
    window.addEventListener('resize', setContainerMaxHeight);

    document.querySelectorAll('.catalog-mobile-menu_root-btn, .catalog-mobile-menu_sub-btn').forEach(catBtn => {
        catBtn.addEventListener('click', () => {
            if (!catBtn.classList.contains('empty') || catBtn.parentNode.querySelector('.catalog-mobile-menu_sublist')) {
                catBtn.parentNode.querySelector('.catalog-mobile-menu_sublist')?.slideToggle(slideSpeed);
                catBtn.classList.toggle('active');

                const chevronIcon = catBtn.querySelector('.icon-chevron-right, .icon-chevron-down');
                chevronIcon?.classList.toggle('icon-chevron-right');
                chevronIcon?.classList.toggle('icon-chevron-down');
            }
        });
    });
}


function setContainerMaxHeight() {
    document.querySelector('#catalogNavMobile').style.maxHeight = `${getMobileWinHeight() - 8}px`;
}

export function catalogMobileReset() {
    const subLists = document.querySelectorAll('.catalog-mobile-menu_sublist');
    subLists.forEach(subList => subList.style.display = 'none');

    const menuBtns = document.querySelectorAll('.catalog-mobile-menu_root-btn, .catalog-mobile-menu_sub-btn');
    menuBtns.forEach(menuBtn => {
        menuBtn.classList.remove('active');
        let chevronIcon = menuBtn.querySelector('.icon-chevron-down');
        chevronIcon?.classList.remove('icon-chevron-down');
        chevronIcon?.classList.add('icon-chevron-right');
    });
}
