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
                // Close other
                liElem.dataset.opened = 'off';
                closeSubCategoryDropdowns(liElem.closest('.catalog-desktop-body-cont'));
                liElem.querySelector('.dropdown-list').style.display = 'block';
                liElem.dataset.opened = 'on';
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