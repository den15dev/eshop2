import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import { fadeIn, fadeOut } from "../effects/fade";

const promoBannerElem = document.querySelector('.promo-banner');
const productCarousels = document.querySelectorAll('.product-carousel');
let swiperCarousels = [];

export const promoSwiper = promoBannerElem ? new Swiper('.promo-banner .swiper', {
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
        initNavButtons(carousel);
    });
}


function calculateBreakpoints(spaceBetween) {
    let breakpoints = {};
    if (productCarousels.length) {
        const productImgWidth = productCarousels[0].querySelector('.product-card_image img').offsetWidth;
        const mainContainer = document.querySelector('main .container');
        const containerMargins = parseInt(getComputedStyle(mainContainer).getPropertyValue('padding-left'), 10);

        // console.log(getComputedStyle(productCarousels[0].querySelector('.product-card_image img')).getPropertyValue('width'));

        for (let i = 1; i <= 5; i++) {
            const bpoint = productImgWidth * i + spaceBetween * (i - 1) + containerMargins * 2;
            breakpoints[bpoint] = {slidesPerView: i};
        }
    }

    // console.log(breakpoints);

    return breakpoints;
}


function initNavButtons(carousel) {
    const prevBtn = carousel.querySelector('.carousel-prev-btn');
    const nextBtn = carousel.querySelector('.carousel-next-btn');
    prevBtn.style.display = 'none';
    nextBtn.style.display = 'none';

    let fadeTimeout;
    carousel.addEventListener('mouseenter', () => {
        fadeIn(prevBtn, 400);
        fadeIn(nextBtn, 400);
        clearTimeout(fadeTimeout);
    });
    carousel.addEventListener('mouseleave', () => {
        fadeTimeout = setTimeout(() => {
            fadeOut(prevBtn, 400);
            fadeOut(nextBtn, 400);
        }, 800);
    });
}