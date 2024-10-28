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
            ,   {
                        data:               null
                    ,   className:          'text-right'
                    ,   render:             data => set_human_datetime(data)
                }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})