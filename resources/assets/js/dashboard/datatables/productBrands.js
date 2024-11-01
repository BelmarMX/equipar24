import {DT_OPTIONS_SSR, number_format, set_human_datetime} from './common.js'
import Alerts                               from "../alerts.js";

$(document).ready(function() {
    $('#productBrands-table').DataTable({
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
            ,   { data: 'is_featured', className: 'text-center', render: data => data ? '⭐' : '' }
            ,   { data: 'count_products', render: count => number_format(count, true) }
            ,   { data: 'preview', className: 'text-center' }
            ,   {
                        data:       null
                    ,   className:  'text-right'
                    ,   render:     data => set_human_datetime(data)
                }
            ,   { data: 'action', className: 'text-center' }
        ]
        ,   layout:                 {
                ...DT_OPTIONS_SSR.layout
            ,   top0start:                  {
                buttons:                        [
                    {
                        text:   '<i class="fa-solid fa-sort me-1"></i> Reordenar'
                        ,   action: (e, dt, node, config) => {
                            if( with_trashed )
                            {
                                Alerts.error('No se puede reordenar marcas en la papelera', 'Disculpa las molestias')
                                return
                            }
                            Alerts.html('Modal para reordenar marcas', 'Reordenar Marcas')
                            /*dt.ajax.url(url_route+'?filter=vigentes').load()*/
                        }
                        ,   className: 'items-center px-4 py-2 bg-white dark:bg-gray-300 border border-gray-300 dark:border-gray-50 rounded-md font-semibold text-xs uppercase shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150 mx-1 text-sky-400'
                    }
                ]
            }
        }
    })
})
