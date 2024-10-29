import {DT_OPTIONS_SSR, set_human_datetime} from './common.js'
import Alerts                               from "../alerts.js";
import axios from "axios";

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

$(document).ready(function() {
    $(document).on('click', '#btn-filter', function(e) {
        e.preventDefault()

        $('#productPrices-table').removeClass('hidden').addClass('display')
        $('#productPrices-table').DataTable().destroy()
        working(true)

        let dataset = {
                product_brand_id:           $('#product_brand_id').val() || null
            ,   product_category_id:        $('#product_category_id').val() || null
            ,   product_subcategory_id:     $('#product_subcategory_id').val() || null
            ,   is_featured:                $('#is_featured').is(':checked') ? 1 : 0
            ,   with_freight:               $('#with_freight').is(':checked') ? 1 : 0
        }
        $('#productPrices-table').DataTable({
                ...DT_OPTIONS_SSR
            ,   pageLength:             -1
            ,   ajax:                   {
                    ...DT_OPTIONS_SSR.ajax
                ,   url:                url_route
                ,   data:               dataset
                ,   error:              O => {
                        $('#btn-update').removeClass('display').addClass('hidden')
                        working(false)
                        Alerts.error('Lo sentimos, la tabla no pudo ser cargada', 'Es necesario contactar a un administrador.')
                    }
            }
            ,   columns:                [
                    ...DT_OPTIONS_SSR.columns
                ,   { data: 'title' }
                ,   { data: 'category' }
                ,   { data: 'subcategory' }
                ,   { data: 'brand' }
                ,   { data: 'old_price' }
                ,   { data: 'new_price' }
            ]
            ,   drawCallback:           O => {
                $('#price_change_controller').removeClass('hidden').addClass('display')
                $('#btn-update-wrapper').removeClass('hidden').addClass('display')
                working(false)
            }
        })
    })

    $(document).on('click', '#btn-change-prices', function(e){
        e.preventDefault();

        let op_value    = parseFloat($('#change_value').val());
        $.each($('[data-price-type="new_price"]'), function(e) {
            let new_price   = 0.00
            let old_price   = parseFloat($(this).attr('data-original-price'))
            old_price       = old_price > 0 ? old_price : 0.00;

            switch ($('#change_type').val())
            {
                case 'fixed_more':
                    new_price   = old_price + op_value
                break
                case 'fixed_less':
                    new_price   = old_price - op_value
                break
                case 'percentage_more':
                    new_price   = old_price + (op_value * old_price) / 100
                break
                case 'percentage_less':
                    new_price   = old_price - (op_value * old_price) / 100
                break
            }

            new_price   = new_price <= 0 ? 0.00 : new_price
            $(this).val(new_price.toFixed(2))
        })
    })

    $(document).on('change', '#new_prices', function(e){
        $('#upload-button-wrapper').removeClass('hidden');
    })

    $(document).on('click', '#btn-download', function(e) {
        working(true)

        let dataset = {
                product_brand_id:           $('#product_brand_id').val() || null
            ,   product_category_id:        $('#product_category_id').val() || null
            ,   product_subcategory_id:     $('#product_subcategory_id').val() || null
            ,   is_featured:                $('#is_featured').is(':checked') ? 1 : 0
            ,   with_freight:               $('#with_freight').is(':checked') ? 1 : 0
        }
        axios.post(generate_massive_file_route, dataset)
            .then(({status, data}) => {
                if( status !== 200 )
                {
                    Alerts.error('Ocurrió un error al general el documento', 'Por favor vuelve a intentarlo')
                    return
                }
                Alerts.confirm('El archivo se ha generado correctamente. ¿Desea descargarlo?', () => window.open('../'+data, '_blank'), 'Archivo Listo')
            })
            .catch(error => {
                Alerts.error(error.code+': '+error.message, 'Lo sentimos, no se pudo descargar el archivo.')
            })
            .finally(() => working(false))
    })

    $(document).on('click', '#btn-upload', function(e) {
        working(true)
        const form_data     = new FormData()
        const file_input    = document.querySelector('#new_prices')
        form_data.append('new_prices', file_input.files[0])

        Alerts.confirm('Vas a actualizar los precios, esta acción no se puede revertir', O => {
            axios.post(update_massive_file_route
                ,   form_data
                ,   { headers:    { 'Content-Type': 'multipart/form-data' } }
            )
                .then(({status, data}) => {
                    if( data.success )
                    {
                        Alerts.success(data.message)
                        $('#new_prices').val('').change()
                        $('label[for="new_prices"]').find('.metadata').text('')
                        $('label[for="new_prices"]').find('embed').addClass('hidden')
                        $('label[for="new_prices"]').find('.svg_load_icon').removeClass('hidden')
                        $('#upload-button-wrapper').addClass('hidden')
                        return
                    }
                    Alerts.error(data.message)
                })
                .catch(error => {
                    Alerts.error(error.code+': '+error.message, 'Lo sentimos, no se pudo cargar el archivo.')
                })
                .finally(() => working(false))
        })
    })

    $(document).on('click', '#btn-update', function(e) {
        e.preventDefault()
        working(true)

        let dataset = []
        $.each($('[data-price-type="new_price"]'), function(e) {
            let id        = $(this).attr('data-original-id')
            let price     = $(this).val()

            dataset.push({id, price})
        })
        Alerts.confirm(`Vas a actualizar ${dataset.length} precios, esta acción no se podrá revertir`, O => {
            axios.post(update_massive_route, {dataset})
                .then(({status, data}) => {
                    if( data.success )
                    {
                        $('#btn-filter').click()
                        Alerts.success(data.message)
                        return
                    }
                    Alerts.error(data.message)
                })
                .catch(error => {
                    Alerts.error(error.code+': '+error.message, 'Lo sentimos, no se pudieron actualizar los precios.')
                })
                .finally(() => working(false))
        })
    })
})
