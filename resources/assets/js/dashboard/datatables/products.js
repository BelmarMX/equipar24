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
            ,   { data: 'category' }
            ,   { data: 'subcategory' }
            ,   { data: 'brand' }
            ,   { data: 'is_featured', className: 'text-center', render: data => data ? '⭐' : '' }
            ,   { data: 'price', render: price => '$'+price }
            ,   { data: 'with_freight', render: data => data ? 'Sí' : 'No' }
            ,   { data: 'preview', className: 'text-center' }
            ,   { data: 'gallery_count', render: count => `${count} <i class="fa-solid fa-images ms-1 fa-sm text-sky-400"></i>` }
            ,   {
                        data:       null
                    ,   className:  'text-right'
                    ,   render:     data => set_human_datetime(data)
                }
            ,   { data: 'action', className: 'text-center' }
        ]
        ,   fixedColumns: {
                start:  3
            ,   end:    1
        }
        ,   layout:                 {
                ...DT_OPTIONS_SSR.layout
            ,   top0start:                  {
                buttons:                        [
                ]
            }
        }
    })
})
