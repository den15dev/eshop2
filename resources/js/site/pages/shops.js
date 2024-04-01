const shopListTab = document.querySelector('#shopListTabPane');

export default function init() {
    if (shopListTab) {
        const shopItems = document.querySelectorAll('.shops_item');

        shopItems.forEach(shopItem => {
            shopItem.addEventListener('click', () => {
                const infoCont = shopItem.querySelector('.shops_item-info');

                if (parseInt(shopItem.dataset.collapsed, 10)) {
                    infoCont.style.display = 'block';
                    shopItem.dataset.collapsed = '0';
                    shopItem.classList.add('active');

                    shopItems.forEach(openedItem => {
                        if (!openedItem.isSameNode(shopItem) && openedItem.dataset.collapsed === '0') {
                            const infoCont = openedItem.querySelector('.shops_item-info');
                            infoCont.style.display = 'none';
                            openedItem.dataset.collapsed = '1';
                            openedItem.classList.remove('active');
                        }
                    });
                }
            });
        });
    }
}