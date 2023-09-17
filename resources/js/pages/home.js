import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';


export const swiper = new Swiper('.swiper', {
    modules: [Pagination],
    spaceBetween: 6,
    autoHeight: true,
    pagination: {
        el: ".swiper-pagination-outside",
        clickable: true,
    },
    breakpoints: {
        576: {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        },
    },
});