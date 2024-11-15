import { DT_OPTIONS_SSR, set_human_datetime } from './common.js'
import Alerts from "../alerts.js";

$(document).ready(function() {
    $('#banners-table').DataTable({
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
            ,   { data: 'link' }
            ,   { data: 'promocion' }
            ,   { data: 'order' }
            ,   { data: 'preview', className: 'text-center' }
            ,   {
                        data:               null
                    ,   className:          'text-right'
                    ,   render:             data => set_human_datetime(data)
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
                                Alerts.error('No es posible reordenar categorías en la papelera', 'Disculpa las molestias')
                                return
                            }
                            location.href = url_route_order
                        }
                        ,   className: 'items-center px-4 py-2 bg-white dark:bg-gray-300 border border-gray-300 dark:border-gray-50 rounded-md font-semibold text-xs uppercase shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150 mx-1 text-sky-400'
                    }
                ]
            }
        }
    })
})
