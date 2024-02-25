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

    for (let i=0; i<shops_data.length; i++) {
        let placemark = new ymaps.Placemark(
            shops_data[i][2],
            {
                balloonContentHeader: shops_data[i][1][0],
                balloonContentBody: shops_data[i][1][1],
                balloonContentFooter: shops_data[i][1][2],
            },
            {
                hideIconOnBalloonOpen: false,
                balloonOffset: [2, -28],
            }
        );
        eshopMap.geoObjects.add(placemark);

        placemark.events.add('click', function () {
            hilightListItem(shops_data[i][0]);
        });

        placemark.events.add('balloonopen', function (e) {
            e.get('target').options.set('preset', 'islands#redIcon');
        });

        placemark.events.add('balloonclose', function (e) {
            e.get('target').options.set('preset', 'islands#blueIcon');
        });

        shops_data[i].push(placemark);
    }

    eshopMap.events.add('balloonclose', closeAllItems);

    shopItems.forEach(shopItem => {
        shopItem.onclick = function (event) {
            const item_id = event.currentTarget.getAttribute('data-shopid');
            hilightListItem(item_id);

            if (lgMedia.matches) {
                let current_shop = [];
                for (let i = 0; i < shops_data.length; i++) {
                    if (shops_data[i][0] === parseInt(item_id, 10)) {
                        current_shop = shops_data[i];
                    }
                }

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
    });

    eshopMap.controls.remove('searchControl');
    eshopMap.controls.remove('typeSelector');
    eshopMap.controls.remove('trafficControl');
}

ymaps.ready(mapInit);