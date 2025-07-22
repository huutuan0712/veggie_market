import Swiper from 'swiper';
import { Navigation, Thumbs } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';

class ProductGallery {
    constructor(mainSelector = '.main-swiper', thumbSelector = '.thumb-swiper') {
        this.mainSelector = mainSelector;
        this.thumbSelector = thumbSelector;
        this.init();
    }

    init() {
        const mainEl = document.querySelector(this.mainSelector);
        const thumbEl = document.querySelector(this.thumbSelector);

        if (!mainEl || !thumbEl) {
            console.warn('Swiper elements not found!');
            return;
        }

        const thumbSwiper = new Swiper(this.thumbSelector, {
            modules: [Thumbs],
            slidesPerView: 4,
            spaceBetween: 10,
            freeMode: true,
            watchSlidesProgress: true,
        });

        new Swiper(this.mainSelector, {
            modules: [Navigation, Thumbs],
            spaceBetween: 10,
            loop: true,
            navigation: {
                nextEl: '.main-swiper .swiper-button-next',
                prevEl: '.main-swiper .swiper-button-prev',
            },
            thumbs: {
                swiper: thumbSwiper,
            },
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => new ProductGallery());
} else {
    new ProductGallery();
}

export default ProductGallery;
