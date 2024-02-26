let mapZoom = 11;
let lgMedia = window.matchMedia('(min-width: 992px)');
const shopItems = document.querySelectorAll('.shops_item');

function hilightListItem(shop_id) {
    const shopItem = document.querySelector(`.shops_item[data-shopid="${shop_id}"]`);
    const infoCont = shopItem.querySelector('.shops_item-info');

    if (parseInt(shopItem.dataset.collapsed, 10)) {
        infoCont.style.display = 'block';
        shopItem.dataset.collapsed = '0';
        shopItem.classList.add('active');

        shopItems.forEach(openedItem => {
            if (!openedItem.isSameNode(shopItem) && openedItem.dataset.collapsed === '0') {
                closeItem(openedItem);
            }
        });
    }
}


function closeItem(shopItem) {
    const infoCont = shopItem.querySelector('.shops_item-info');
    infoCont.style.display = 'none';
    shopItem.dataset.collapsed = '1';
    shopItem.classList.remove('active');
}


function closeAllItems() {
    shopItems.forEach(openedItem => {
        if (openedItem.dataset.collapsed === '0') {
            closeItem(openedItem);
        }
    });
}


function mapInit(){
    let eshopMap = new ymaps.Map("map", {
        center: [55.75, 37.62],
        zoom: mapZoom
    });

    shops_data.forEach(shop => {
        let placemark = new ymaps.Placemark(
            shop[2],
            {
                balloonContentHeader: shop[1][0],
                balloonContentBody: shop[1][1],
                // balloonContentFooter: shop[1][2],
            },
            {
                hideIconOnBalloonOpen: false,
                balloonOffset: [2, -28],
            }
        );
        eshopMap.geoObjects.add(placemark);

        placemark.events.add('click', function () {
            hilightListItem(shop[0]);
        });

        placemark.events.add('balloonopen', function (e) {
            e.get('target').options.set('preset', 'islands#redIcon');
        });

        placemark.events.add('balloonclose', function (e) {
            e.get('target').options.set('preset', 'islands#blueIcon');
        });

        shop.push(placemark);
    });

    eshopMap.events.add('balloonclose', closeAllItems);

    shopItems.forEach(shopItem => {
        shopItem.addEventListener('click', () => {
            panMapToLocation(eshopMap, shopItem);
        });
    });

    eshopMap.controls.remove('searchControl');
    eshopMap.controls.remove('typeSelector');
    eshopMap.controls.remove('trafficControl');
}


function panMapToLocation(eshopMap, shopItem) {
    const item_id = shopItem.dataset.shopid;

    if (lgMedia.matches) {
        const current_shop = shops_data.find(
            shop => shop[0] === parseInt(item_id, 10)
        );

        const center = current_shop[2];
        const placemark = current_shop[3];

        eshopMap.setCenter(center, 14, {
            duration: 500,
            timingFunction: 'ease',
        }).then(function () {
            placemark.balloon.open();
        });
    }
}


ymaps.ready(mapInit);