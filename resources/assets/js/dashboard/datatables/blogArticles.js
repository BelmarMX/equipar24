import { DT_OPTIONS_SSR, set_human_datetime } from './common.js'

$(document).ready(function() {
    $('#blogArticles-table').DataTable({
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
            ,   { data: 'category' }
            ,   { data: 'summary' }
            ,   { data: 'preview', className: 'text-center' }
            ,   { data: 'published_at', className: 'text-right', render: published_at => moment(published_at).format('DD/MM/YYYY') }
            ,   {
                        data:               null
                    ,   className:          'text-right'
                    ,   render:             data => set_human_datetime(data)
                }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
