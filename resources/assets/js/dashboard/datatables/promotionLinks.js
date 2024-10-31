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

        $('#promotionLinks-table').removeClass('hidden').addClass('display')
        $('#promotionLinks-table').DataTable().destroy()
        working(true)

        let dataset = {
                product_brand_id:           $('#product_brand_id').val() || null
            ,   product_category_id:        $('#product_category_id').val() || null
            ,   product_subcategory_id:     $('#product_subcategory_id').val() || null
            ,   is_featured:                $('#is_featured').is(':checked') ? 1 : 0
            ,   with_freight:               $('#with_freight').is(':checked') ? 1 : 0
        }
        $('#promotionLinks-table').DataTable({
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
                ,   { data: 'old_link', className: 'text-center' }
                ,   { data: 'new_link', className: 'text-center' }
                ,   { data: 'prices', className: 'text-right' }
            ]
            ,   drawCallback:           O => {
                $('#link_change_controller').removeClass('hidden').addClass('display')
                $('#btn-update-wrapper').removeClass('hidden').addClass('display')
                working(false)
            }
        })
    })

    $(document).on('click', '#btn-change-links', function(e){
        e.preventDefault();
        $.each($('[data-link-type="new_link"]'), function(e) {
            switch ($('#change_type').val())
            {
                case 'link':
                    $(this).prop('checked', true)
                break
                default:
                    $(this).prop('checked', false)
                break
            }
        })
    })

    $(document).on('click', '#btn-update', function(e) {
        e.preventDefault()
        working(true)

        let dataset = []
        $.each($('[data-link-type="new_link"]'), function(e) {
            let id              = $(this).attr('data-original-id')
            let linked          = $(this).is(':checked') ? 1 : 0

            dataset.push({id, linked})
        })
        Alerts.confirm(`Vas a actualizar ${dataset.length} productos, esta acción no se podrá revertir`, O => {
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
                    Alerts.error(error.code+': '+error.message, 'Lo sentimos, no se pudieron actualizar los fletes.')
                })
                .finally(() => working(false))
        })
    })
})
