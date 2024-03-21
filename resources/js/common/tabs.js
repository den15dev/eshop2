export default function init() {
    const tabContainers = document.querySelectorAll('.tab-cont');

    tabContainers.forEach(tabCont => {
        const tabs = tabCont.querySelectorAll('div.tab-btn');

        tabs.forEach(tabBtn => {
            tabBtn.addEventListener('click', () => {
                switchTabTo(tabCont, tabBtn);
            });
        });
    });
}


export function switchTabTo(tabContainer, tabBtn) {
    const activeTabBtn = tabContainer.querySelector('.tab-btn.active');

    if (!tabBtn.isEqualNode(activeTabBtn)) {
        const activePaneId = activeTabBtn.id;
        const activePane = document.querySelector(`#${activePaneId}Pane`);
        const paneId = tabBtn.id;
        const pane = document.querySelector(`#${paneId}Pane`);

        if (pane && activePane) {
            activeTabBtn.classList.remove('active');
            activeTabBtn.classList.add('link');
            tabBtn.classList.remove('link');
            tabBtn.classList.add('active');

            activePane.classList.remove('active');
            pane.classList.add('active');
        } else {
            console.error('Tab pane not found.');
        }
    }
}