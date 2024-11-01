import {DT_OPTIONS_SSR, number_format, set_human_datetime} from './common.js'

$(document).ready(function() {
    $('#promotions-table').DataTable({
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
            ,   { data: 'status' }
            ,   { data: 'title' }
            ,   { data: 'description' }
            ,   { data: 'preview', className: 'text-center' }
            ,   {
                        data:               null
                    ,   render:             data => {
                        return `${data.discount_type === 'percentage' ? number_format(data.amount)+'%' : '$'+number_format(data.amount)}`
                    }
                }
            ,   {
                    data:                   null
                ,   className:              'text-right'
                ,   render:                 data => {
                    return `${moment(data.starts_at).format('DD/MM/YYYY')} <i class="fa-solid fa-play text-indigo-400" data-tooltip="Fecha de inicio"></i><br>
                        ${moment(data.ends_at).format('DD/MM/YYYY')} <i class="fa-solid fa-stop text-red-400" data-tooltip="Fecha de finalización"></i> `
                }
            }
            ,   {
                        data:               null
                    ,   className:          'text-right'
                    ,   render:             data => set_human_datetime(data)
                }
            ,   { data: 'action', className: 'text-center' }
        ]
        ,   layout:                 {
            top0start:                  {
                buttons:                    [
                    {
                            text:   '<i class="fa-regular fa-calendar-check me-1"></i> Vigentes'
                        ,   action: (e, dt, node, config) => {
                                dt.ajax.url(url_route+'?filter=vigentes').load()
                            }
                        ,   className: 'items-center px-4 py-2 bg-white dark:bg-gray-300 border border-gray-300 dark:border-gray-50 rounded-md font-semibold text-xs uppercase shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150 mx-1 text-emerald-400'
                    },
                    {
                            text: '<i class="fa-regular fa-calendar-xmark me-1"></i> Vencidas'
                        ,   action: (e, dt, node, config) => {
                                dt.ajax.url(url_route+'?filter=vencidas').load()
                            }
                        ,   className: 'items-center px-4 py-2 bg-white dark:bg-gray-300 border border-gray-300 dark:border-gray-50 rounded-md font-semibold text-xs uppercase shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150 mx-1 text-red-400'
                    },
                    {
                            text: '<i class="fa-regular fa-calendar me-1"></i> Próximas'
                        ,   action: (e, dt, node, config) => {
                                dt.ajax.url(url_route+'?filter=proximas').load()
                            }
                        ,   className: 'items-center px-4 py-2 bg-white dark:bg-gray-300 border border-gray-300 dark:border-gray-50 rounded-md font-semibold text-xs uppercase shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150 mx-1 text-indigo-400'
                    }
                ]
            }
        }
    })
})
