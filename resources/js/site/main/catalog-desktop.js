const bodyConts = Array.from(document.querySelectorAll('#catalogNavDesktop .catalog-desktop-body-cont'));
let catalogMenuTimeout;

export function catalogDesktopRoot() {

    document.querySelectorAll('.catalog-desktop-root-list > li').forEach(newLiElem => {
        newLiElem.addEventListener('mouseenter', function () {
            catalogMenuTimeout = setTimeout(() => {
                const newCatId = newLiElem.dataset.id;
                const currentOpenedBody = bodyConts.filter(bodyCont => bodyCont.dataset.opened === 'on')[0];
                const currentOpenedId = currentOpenedBody.dataset.id;

                if (currentOpenedId !== newCatId) {
                    const catalogNavDesktop = document.querySelector('#catalogNavDesktop');
                    const targetBody = bodyConts.filter(bodyCont => bodyCont.dataset.id === newCatId);

                    if (targetBody.length) {
                        catalogNavDesktop.style.height = 'auto';

                        currentOpenedBody.style.display = 'none';
                        currentOpenedBody.dataset.opened = 'off';

                        targetBody[0].style.display = 'block';
                        targetBody[0].dataset.opened = 'on';

                        const h1 = catalogNavDesktop.offsetHeight;
                        catalogNavDesktop.style.height = `${h1}px`;

                        newLiElem.classList.add('active');

                        // Make old button inactive
                        const oldLiElem = document.querySelector('.catalog-desktop-root-list > li[data-id="' + currentOpenedId + '"]');
                        oldLiElem.classList.remove('active');
                    }
                }
            }, 250);
        });
    });

    document.querySelectorAll('.catalog-desktop-root-list > li').forEach(liElem => {
        liElem.addEventListener('mouseleave', function () {
            clearTimeout(catalogMenuTimeout);
        });
    });
}


let catalogDDTimeout;
const hoverDropdowns = document.querySelectorAll('.dropdown-hover');

function closeSubCategoryDropdowns(bodyCont) {
    bodyCont.querySelectorAll('.dropdown-hover').forEach(liElem => {
        if (liElem.dataset.opened === 'on') {
            liElem.querySelector('.dropdown-list').style.display = 'none';
        }
    });
}

export function catalogDesktopDropdowns() {
    hoverDropdowns.forEach(liElem => {
        liElem.addEventListener('mouseenter', function () {
            clearTimeout(catalogDDTimeout);
            catalogDDTimeout = setTimeout(() => {
                // Close others
                liElem.dataset.opened = 'off';
                closeSubCategoryDropdowns(liElem.closest('.catalog-desktop-body-cont'));

                // Open current
                const ddListElem = liElem.querySelector('.dropdown-list');
                ddListElem.style.display = 'block';
                liElem.dataset.opened = 'on';

                // Set left margin if button is multiline
                const maxWidth = parseInt(getComputedStyle(liElem.closest('section')).maxWidth, 10);
                const marginLeft = getListLeftMargin(liElem.querySelector('.dropdown-btn'), maxWidth);
                if (marginLeft) {
                    ddListElem.style.marginLeft = `${marginLeft}px`;
                }
            }, 200);
        });

        liElem.addEventListener('mouseleave', function () {
            clearTimeout(catalogDDTimeout);
            catalogDDTimeout = setTimeout(() => {
                liElem.querySelector('.dropdown-list').style.display = 'none';
                closeSubCategoryDropdowns(liElem.closest('.catalog-desktop-body-cont'));
                liElem.dataset.opened = 'off';
            }, 200);
        });
    });
}

/**
 * Calculates actual width of a multiline text block.
 *
 * @param buttonElem
 * @param maxWidth
 * @returns {number}
 */
function getListLeftMargin(buttonElem, maxWidth) {
    const text = buttonElem.innerText;
    const extraWidth = 18; // Pixels for chevron icon with its spaces
    let marginLeft = 0;

    // Create temporary li and div elements
    const ulElem = buttonElem.closest('ul');
    const tempLiElem = document.createElement('li');
    ulElem.appendChild(tempLiElem);
    const tempDivElem = document.createElement('div');
    tempDivElem.style.width = 'fit-content';
    tempLiElem.appendChild(tempDivElem);

    let wordArr = text.split(' ');
    wordArr = wordArr.filter(word => word.length > 0);

    let curLine = '';
    let curLineWidth = 0;
    let curButtonWidth = 0;
    let lineWidthArr = [];
    wordArr.forEach(word => {
        curLine === '' ? curLine += word : curLine += ' ' + word;
        tempDivElem.innerHTML = curLine;

        curButtonWidth = tempDivElem.offsetWidth;
        if (maxWidth <= (curButtonWidth + extraWidth)) {
            lineWidthArr.push(curLineWidth);
            curLine = word;
        }
        curLineWidth = curButtonWidth;
    });

    tempDivElem.innerHTML = curLine;
    lineWidthArr.push(tempDivElem.offsetWidth + extraWidth);

    // Remove temp elements
    tempLiElem.remove();

    if (lineWidthArr.length > 1) {
        const longestLine = Math.max(...lineWidthArr);
        marginLeft = -(maxWidth - longestLine);
    }

    return marginLeft;
}