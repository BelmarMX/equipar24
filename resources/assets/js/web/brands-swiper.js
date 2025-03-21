import Swiper from 'swiper'
import {Autoplay, Pagination} from 'swiper/modules'

import 'swiper/css'
import 'swiper/css/pagination'

const swiper = new Swiper('.swiper-brands',{
    modules: [
        Pagination, Autoplay
    ]
    ,   slidesPerView: 1
    ,   spaceBetween: 30
    ,   loop: true
    ,   centeredSlides: true
    ,   grabCursor: true
    ,   autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        }
    ,   pagination: {
            el: '.brand-swiper-pagination'
        ,   clickable: true
    }
})
