import { DT_OPTIONS_SSR, set_human_datetime } from './common.js'

$(document).ready(function() {
    $('#reels-table').DataTable({
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
                    ,   render: ({link, link_title, link_summary}) => {
                            if( link === null )
                            { return 'Sin enlace' }

                            return `<a href="${link}" target="_blank">
                                <i class="fa-solid fa-link me-1"></i> ${link_title || 'Enlace'}
                            </a>`
                    }
                }
            ,   { data: 'promocion' }
            ,   { data: 'producto' }
            ,   {
                    data:                   null
                ,   className:              'text-right'
                ,   render:                 data => {
                    return `${moment(data.starts_at).format('DD/MM/YYYY')} <i class="fa-solid fa-play text-indigo-400" data-tooltip="Fecha de inicio"></i><br>
                        ${moment(data.ends_at).format('DD/MM/YYYY')} <i class="fa-solid fa-stop text-red-400" data-tooltip="Fecha de finalización"></i> `
                }
            }
            ,   { data: 'preview', className: 'text-center' }
            ,   {
                        data:               null
                    ,   className:          'text-right'
                    ,   render:             data => set_human_datetime(data)
                }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
