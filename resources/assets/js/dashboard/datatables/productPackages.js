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
            ,   { data: 'url' }
            ,   {
                    data: null
                ,   render: ({id, product_count}) => {
                    return `<span class="font-semibold text-sky-600 hover:text-sky-900">${number_format(product_count, true)}</span>`
                }
            }
            ,   { data: 'preview', className: 'text-center' }
            ,   {
                    data:                   null
                ,   className:              'text-right'
                ,   render:                 data => {
                    return `${moment(data.starts_at).format('DD/MM/YYYY')} <i class="fa-solid fa-play text-indigo-400" data-tooltip="Fecha de inicio"></i><br>
                        ${moment(data.ends_at).format('DD/MM/YYYY')} <i class="fa-solid fa-stop text-red-400" data-tooltip="Fecha de finalización"></i> `
                }
            }
            ,   {
                        data:       null
                    ,   className:  'text-right'
                    ,   render:     data => set_human_datetime(data)
                }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
