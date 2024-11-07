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
            ,   { data: 'type', render: type => { return type === 'quotation' ? 'Cotización' : 'Contacto' } }
            ,   {
                        data: null
                    ,   render: ({form_contact}) => {
                            return `<strong>${form_contact.name}</strong><br>
                            <span>${form_contact.email}</span>
                            `
                        }
                }
            ,   { data: 'state' }
            ,   { data: 'city' }
            ,   { data: 'estimated_value' }
            ,   {
                        data: 'assigned'
                    ,   render: assigned => {
                            if( !assigned )
                            { return 'Sin asignación' }
                            return `<strong>${assigned.name}</strong><br>
                                    <span>${assigned.email}</span>
                                    `
                        }
                }
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
                    buttons:                    [
                    {
                            text:   '<i class="fa-solid fa-thumbs-up me-1"></i> Atendidos'
                        ,   action: (e, dt, node, config) => {
                                dt.ajax.url(url_route+'?filter=approved').load()
                            }
                        ,   className: 'items-center px-4 py-2 bg-white dark:bg-gray-300 border border-gray-300 dark:border-gray-50 rounded-md font-semibold text-xs uppercase shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150 mx-1 text-emerald-400'
                    },
                    {
                            text: '<i class="fa-solid fa-thumbs-down me-1"></i> Rechazados'
                        ,   action: (e, dt, node, config) => {
                                dt.ajax.url(url_route+'?filter=rejected').load()
                            }
                        ,   className: 'items-center px-4 py-2 bg-white dark:bg-gray-300 border border-gray-300 dark:border-gray-50 rounded-md font-semibold text-xs uppercase shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150 mx-1 text-red-400'
                    },
                    {
                            text: '<i class="fa-solid fa-stopwatch me-1"></i> Pendientes'
                        ,   action: (e, dt, node, config) => {
                                dt.ajax.url(url_route+'?filter=pending').load()
                            }
                        ,   className: 'items-center px-4 py-2 bg-white dark:bg-gray-300 border border-gray-300 dark:border-gray-50 rounded-md font-semibold text-xs uppercase shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150 mx-1 text-indigo-400'
                    },
                    {
                        text: '<i class="fa-regular fa-dollar-sign" data-tooltip="Solo cotizaciones"></i>'
                        ,   action: (e, dt, node, config) => {
                            dt.ajax.url(url_route+'?filter=only_quotation').load()
                        }
                        ,   className: 'items-center px-4 py-2 bg-white dark:bg-gray-300 border border-gray-300 dark:border-gray-50 rounded-md font-semibold text-xs uppercase shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150 mx-1 text-sky-400'
                    },
                    {
                        text: '<i class="fa-solid fa-envelope-open" data-tooltip="Solo contactos"></i>'
                        ,   action: (e, dt, node, config) => {
                            dt.ajax.url(url_route+'?filter=only_contact').load()
                        }
                        ,   className: 'items-center px-4 py-2 bg-white dark:bg-gray-300 border border-gray-300 dark:border-gray-50 rounded-md font-semibold text-xs uppercase shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150 mx-1 text-sky-400'
                    }
                ]
            }
        }
    })
})
