import Swiper from 'swiper'
import { Pagination } from 'swiper/modules'

import 'swiper/css'
import 'swiper/css/pagination'

const swiper = new Swiper('.swiper-categories',{
        modules: [
            Pagination
        ]
    ,   slidesPerView: 4
    ,   spaceBetween: 30
    ,   centeredSlides: true
    ,   loop: true
    ,   pagination: {
                el: '.swiper-pagination'
            ,   clickable: true
    }
    ,   breakpoints: {
            390: {
            slidesPerView: 1
        }
        ,   1024: {
            slidesPerView: 3
        }
        ,   1360: {
            slidesPerView: 4
        }
    }
})
