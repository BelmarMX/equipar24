// Include Bootstrap5
import 'bootstrap'
import {Tooltip} from 'bootstrap';

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
    const scroll_container = document.querySelector('.scroll_categories--list')
    scroll_container.addEventListener('wheel', e => {
        e.preventDefault()
        scroll_container.scrollLeft += e.deltaY
    })
}
