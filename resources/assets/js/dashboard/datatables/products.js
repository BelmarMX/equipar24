import {DT_OPTIONS_SSR, set_human_datetime} from './common.js'

$(document).ready(function() {
    $('#products-table').DataTable({
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
            ,   { data: 'model' }
            ,   { data: 'is_featured', className: 'text-center', render: data => data ? '⭐' : '' }
            ,   { data: 'category' }
            ,   { data: 'subcategory' }
            ,   { data: 'brand' }
            ,   { data: 'price', render: price => '$'+price }
            ,   { data: 'with_freight', render: data => data ? 'Sí' : 'No' }
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
                ]
            }
        }
    })
})
