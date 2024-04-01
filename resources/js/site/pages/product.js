import { Fancybox, Carousel } from "@fancyapps/ui";
import { Thumbs } from "@fancyapps/ui/dist/carousel/carousel.thumbs.esm";
import { switchTabTo } from "../../common/tabs.js";
import { closeDropdown } from "../../common/dropdowns.js";

const productMainCont = document.querySelector('.product-main-cont');

export default function init() {
    if (productMainCont) {
        // Fancybox
        const imageCont = document.querySelector('#productImages');

        if (imageCont) {
            const options = {
                infinite: false,
                Dots: false,
                Navigation: false,
                Thumbs: {
                    type: "classic",
                    Carousel: {
                        center: false,
                    },
                },
            };

            new Carousel(imageCont, options, { Thumbs });

            Fancybox.bind('[data-fancybox="product_images"]', {
                wheel: 'slide',
                Thumbs: {
                    type: "classic",
                },
            });
        }


        // Specification link
        const allSpecsLink = document.querySelector('ul.product-main_spec-list div.link');

        if (allSpecsLink) {
            // Scroll to specifications
            const tabCont = document.querySelector('#productPageTabs');
            const specTabBtn = document.querySelector('#specTab');

            allSpecsLink.addEventListener('click', () => {
                switchTabTo(tabCont, specTabBtn);

                const headerOffset = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--header-row2-height'), 10) + 10;
                const scrollDiv = tabCont.offsetTop - headerOffset;
                window.scrollTo({ top: scrollDiv, behavior: 'smooth'});
            });
        }


        // Attribute dropdowns: close on click on active item
        const attributeConts = document.querySelectorAll('.attribute-cont');

        if (attributeConts) {
            attributeConts.forEach(attrCont => {
                const ddItems = attrCont.querySelectorAll('.dropdown-item');

                ddItems.forEach(ddItem => {
                    ddItem.addEventListener('click', () => {
                        if (ddItem.classList.contains('active')) {
                            const dropdownBtn = ddItem.closest('.attribute-cont').querySelector('.dropdown-btn');
                            closeDropdown(dropdownBtn);
                        }
                    });
                });
            });
        }
    }

}