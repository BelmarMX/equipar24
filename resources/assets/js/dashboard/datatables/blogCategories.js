import {DT_OPTIONS_SSR, set_human_datetime} from './common.js'

$(document).ready(function() {
    $('#blogCategories-table').DataTable({
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
            ,   { data: 'count_articles' }
            ,   {
                        data:       null
                    ,   className:  'text-right'
                    ,   render:     data => set_human_datetime(data)
                }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
