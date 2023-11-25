import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

/* -------------- Promo Banner --------------- */

const promoBannerElem = document.querySelector('.promo-banner');

const promoSwiper = promoBannerElem ? new Swiper('.promo-banner .swiper', {
    modules: [Pagination, Autoplay],
    autoHeight: true,
    speed: 500,
    loop: true,
    pagination: {
        el: ".swiper-pagination-outside",
        clickable: true,
    },
    autoplay: {
        delay: 5000,
        pauseOnMouseEnter: true,
    },

    breakpoints: {
        576: {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true,
            },
        },
    },
}) : null;


/* -------------- Product Carousels --------------- */

const productCarousels = document.querySelectorAll('.product-carousel');
let swiperCarousels = [];

export function initProductCarousels() {
    const spaceBetween = 20;
    const breakpoints = calculateBreakpoints(spaceBetween);

    productCarousels.forEach(carousel => {
        const swiperCarousel = new Swiper(carousel, {
            modules: [Navigation],
            slidesPerView: 1,
            spaceBetween: spaceBetween,
            autoHeight: true,
            navigation: {
                nextEl: ".carousel-next-btn",
                prevEl: ".carousel-prev-btn",
                disabledClass: "disabled",
            },
            breakpoints,
        });

        swiperCarousels.push(swiperCarousel);

        const showNavigation = swiperCarousel.params.slidesPerView < swiperCarousel.slides.length;
        initNavButtons(carousel, showNavigation);
    });
}


function calculateBreakpoints(spaceBetween) {
    let breakpoints = {};
    if (productCarousels.length) {
        const productImgWidth = productCarousels[0].querySelector('.product-card_image img').offsetWidth;
        const mainContainer = document.querySelector('main .container');
        const containerMargins = parseInt(getComputedStyle(mainContainer).getPropertyValue('padding-left'), 10);

        for (let i = 1; i <= 5; i++) {
            const bpoint = productImgWidth * i + spaceBetween * (i - 1) + containerMargins * 2;
            breakpoints[bpoint] = {slidesPerView: i};
        }
    }

    return breakpoints;
}


function initNavButtons(carousel, showNavigation) {
    const prevBtn = carousel.querySelector('.carousel-prev-btn');
    const nextBtn = carousel.querySelector('.carousel-next-btn');

    if (!showNavigation) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
    }
}
