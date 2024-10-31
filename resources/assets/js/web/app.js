// Include Bootstrap5
import 'bootstrap'
import {Tooltip}    from 'bootstrap';
import Plyr         from "plyr";
import swal         from "sweetalert2";

// Initialize the tooltips
const tooltipTriggerList = []
    .slice
    .call( document.querySelectorAll('[data-bs-toggle="tooltip"]') )

const tooltipList   = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl)
})

// Document Ready
window.onload = event => {

    // -> Search bar
    document.getElementById('search-form')
        .addEventListener('submit', function(event) {
            document.getElementById('load8')
                .removeAttribute('hidden')
        })

    // -> Contact bottom button
    document.getElementById('floating_button').addEventListener('click', event => {
        let container_links = document.getElementById('btn__contactanos--links')
        if( container_links.classList.contains('show_me_the_money') )
        {
            container_links.classList.remove('show_me_the_money')
            container_links.classList.add('black_sheep_wall')
            setTimeout(() => {
                container_links.classList.add('hide')
            }, 250)
        }
        else
        {
            container_links.classList.remove('hide')
            container_links.classList.remove('black_sheep_wall')
            container_links.classList.add('show_me_the_money')
        }
    })

    // Header when scroll
    document.addEventListener('scroll', event => {
        let header = document.querySelector('header');

        if( header.offsetTop >= header.offsetHeight )
        {
            header.classList.add('min')
        }
        else
        {
            header.classList.remove('min')
        }
    })

    // Document Loader
    document.getElementById('load8')
        .setAttribute('hidden', 'hidden')

    if( JSON.parse( localStorage.getItem('products') ) && JSON.parse( localStorage.getItem('products') ).length > 0 )
    {
        document.getElementById('link_quotation')
            .classList
            .remove('empty')
    }

    // Scroll horizontal
    if( document.querySelector('.scroll_categories--list') )
    {
        const scroll_container = document.querySelector('.scroll_categories--list')
        scroll_container.addEventListener('wheel', e => {
            e.preventDefault()
            scroll_container.scrollLeft += e.deltaY
        })
    }

    // Video reels
    if( document.querySelector('.reels__item--video') )
    {
        document.querySelectorAll('.reels__item--video').forEach(el => {
            el.addEventListener('click', event => {
                event.preventDefault()
                let video_url = event.target.src
                let html    = `<div class="reel-story">
                    <video class="js-player mx-auto" playsinline controls autoplay>
                        <source src="${ video_url }"/>
                    </video>
                </div>`
                swal.fire({
                    html:               html,
                    showCloseButton:    true,
                    showCancelButton:   false,
                    showConfirmButton:  false,
                    focusConfirm:       false,
                    customClass:        'reels_pop'
                })
                Plyr.setup('.js-player', { controls: ['play-large', 'restart', 'play', 'progress', 'current-time', 'duration','mute', 'volume', 'fullscreen'] });
                document.querySelector('.bs-tooltip-auto').remove()
            })
        })
    }
}
