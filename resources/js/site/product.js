import { Fancybox, Carousel } from "@fancyapps/ui";
import { Thumbs } from "@fancyapps/ui/dist/carousel/carousel.thumbs.esm";

const imageCont = document.querySelector('#productImages');

export default function init() {
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
}