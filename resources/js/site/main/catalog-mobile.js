import '../../common/effects/slide.js';
import { smMedia, getMobileWinHeight } from '../../common/global.js';

const slideSpeed = 100;

function setItemPaddings() {
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
        const subList = parentList.querySelector('ul.catalog-mobile-sublist');
        if (subList) {
            n++;
            Array.from(subList.children).forEach(liElem => {
                liElem.querySelector('a, div').style.paddingLeft = `${16 + iconContWidth + iconGap + paddingStepPx * (n - 1)}px`;
                findChildrenList(liElem);
            });
            n--;
        }
    }

    document.querySelectorAll('#catalogNavMobile .catalog-mobile-list > li').forEach(liElem => {
        findChildrenList(liElem);
    });
}

function setContainerMaxHeight() {
    document.querySelector('#catalogNavMobile').style.maxHeight = `${getMobileWinHeight() - 8}px`;
}

export function catalogMobileReset() {
    document.querySelectorAll('#catalogNavMobile ul.catalog-mobile-sublist').forEach(ulElem => {
        ulElem.style.display = 'none';
    });
    document.querySelectorAll('#catalogNavMobile div.cat-btn1, #catalogNavMobile div.cat-btn2').forEach(catBtn => {
        catBtn.classList.remove('active');
        let chevronIcon = catBtn.querySelector('.icon-chevron-down');
        chevronIcon?.classList.remove('icon-chevron-down');
        chevronIcon?.classList.add('icon-chevron-right');
    });
}

export default function init() {
    setItemPaddings();
    setContainerMaxHeight();
    window.addEventListener('resize', setContainerMaxHeight);
    smMedia.addEventListener('change', setItemPaddings);

    document.querySelectorAll('#catalogNavMobile div.cat-btn1, #catalogNavMobile div.cat-btn2').forEach(catBtn => {
        catBtn.addEventListener('click', () => {
            if (!catBtn.classList.contains('empty') || catBtn.parentNode.querySelector('.catalog-mobile-sublist')) {
                catBtn.parentNode.querySelector('ul.catalog-mobile-sublist')?.slideToggle(slideSpeed);
                catBtn.classList.toggle('active');
                let chevronIcon = catBtn.querySelector('.icon-chevron-right, .icon-chevron-down');
                chevronIcon?.classList.toggle('icon-chevron-right');
                chevronIcon?.classList.toggle('icon-chevron-down');
            }
        });
    });
}