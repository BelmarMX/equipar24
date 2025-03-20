import {DT_OPTIONS_SSR, number_format, set_human_datetime} from './common.js'
import Alerts                               from "../alerts.js";

$(document).ready(function() {
    $('#productPackages-table').DataTable({
            ...DT_OPTIONS_SSR
        ,   ajax:                   {
                ...DT_OPTIONS_SSR.ajax
            ,   url:                url_route
            ,   data:               {
                    with_trashed
                }
        }
        ,   columns:                [
                ...DT_OPTIONS_SSR.columns
            ,   { data: 'title' }
            ,   {
                    data: null
                ,   render: ({id, count_products}) => {
                    return `<a href="/dashboard/products/index/category/${id}" class="font-semibold text-sky-600 hover:text-sky-900">${number_format(count_products, true)}</a>`
                }
            }
            ,   { data: 'preview', className: 'text-center' }
            ,   {
                        data:       null
                    ,   className:  'text-right'
                    ,   render:     data => set_human_datetime(data)
                }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
