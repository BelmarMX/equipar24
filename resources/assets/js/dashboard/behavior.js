import axios                                from "axios";
import Alert                                from "./alerts";
import {URL_PARAMS}                         from "./datatables/common.js";
const working                               = activate => {
    if( activate)
    {
        $('[data-loader]').removeClass('hidden')
    }
    else
    {
        $('[data-loader]').addClass('hidden')
    }
}

const toast_created                         = title => {
    Alert.toast(title)
}

const clear_path_name                       = O => {
    let url     = new URL(window.location.href)
    let params  = new URLSearchParams(url.search)
    params.forEach((value, key) => {
        params.delete(key);
    })
    window.history.replaceState({}, document.title, url.pathname);
}
$(document).ready(function() {
    if( typeof $().select2 === 'function' )
    {
        $('.select-2').select2({ language: "es" })
    }

    $('[data-state-fill]').on('change', function() {
        let state_id    = $(this).find('select').val();
        let cities_el   = $(this).attr('data-state-fill');

        axios.post('/contacto/cities'
            ,   {
                state_id: state_id
            })
            .then(({data}) => {
                $(cities_el).empty()
                $(cities_el).append(`<option selected>Ciudad</option>`)
                data.forEach(city => {
                    $(cities_el).append(`<option value="${city.id}">${city.name}</option>`)
                })
            })
            .catch(error => {
                console.error('Cities Error', error)
            })
    })

    $('[load-iframe]').on('focusout', function() {
        let iframe_id   = $(this).attr('load-iframe');
        let value       = $(this).find('input').val()

        $(iframe_id).attr('src', value)
    })

    $(document).on('click', '[data-confirm-redirect]', function(e) {
        e.preventDefault()
        let attribute   = $(this).attr('data-confirm-redirect')
        console.log('dcr', attribute)
        let ask         = attribute !== '' ? attribute : '¿Estás seguro de realizar esta acción?'
        Alert.confirm('Perderás los cambios que no hayas guardado', () => location.href = $(this).attr('href'), ask )
    })

    if( URL_PARAMS.get('created') )
    {
        clear_path_name()
        Alert.toast('Registro creado con éxito')
    }
    if( URL_PARAMS.get('updated') )
    {
        clear_path_name()
        Alert.toast('Registro actualizado con éxito')
    }
    if( URL_PARAMS.get('restored') )
    {
        clear_path_name()
        Alert.toast('Registro restaurado con éxito')
    }
    if( URL_PARAMS.get('deleted') )
    {
        clear_path_name()
        Alert.toast('Registro eliminado con éxito')
    }
    if( URL_PARAMS.get('error') )
    {
        clear_path_name()
        Alert.toast('Lo sentimos: algo salió mal', 'error')
    }

    working(false)
})