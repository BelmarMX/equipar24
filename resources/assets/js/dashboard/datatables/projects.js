import { DT_OPTIONS_SSR, set_human_datetime } from './common.js'

$(document).ready(function() {
    $('#projects-table').DataTable({
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
            ,   { data: 'description' }
            ,   { data: 'preview', className: 'text-center' }
            ,   { data: 'gallery_count', render: count => `${count} <i class="fa-solid fa-images ms-1 fa-sm text-sky-400"></i>` }
            ,   {
                        data:               null
                    ,   className:          'text-right'
                    ,   render:             data => set_human_datetime(data)
                }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
