// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { Navigation, Pagination,Autoplay } from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';


const swiper = new Swiper('.swiper', {
    // configure Swiper to use modules
    modules: [Navigation, Pagination, Autoplay],

    // Optional parameters
    // direction: 'vertical',
    loop: true,

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
        el: '.swiper-scrollbar',
    },

    // Autoplayオプションを設定
    autoplay: {
        delay: 5000, // 自動再生の間隔（ミリ秒）
        disableOnInteraction: false, // ユーザーの操作後も自動再生を続けるかどうか
    },
});;
