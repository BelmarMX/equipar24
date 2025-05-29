import {DT_OPTIONS_SSR, set_human_datetime, number_format} from './common.js'

$(document).ready(function() {
    console.log(number_format(0))
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
            ,   { data: 'in_stock', className: 'text-center', render: data => data ? '<span class="cursor-pointer" data-tooltip="En existencia">🟢</span>' : '<span class="cursor-pointer" data-tooltip="Sin existencias">🔴</span>' }
            ,   { data: 'title' }
            ,   { data: 'model' }
            ,   { data: 'brand' }
            ,   { data: 'category' }
            ,   { data: 'subcategory' }
            ,   { data: null, render: ({price, promotion_price}) => {
                    if( promotion_price )
                    {
                        return `<small style="text-decoration: line-through">$${number_format(price, true)}</small><br>$${number_format(promotion_price, true)}`
                    }
                    return `$${number_format(price, true)}`
                } }
            ,   { data: 'is_featured', className: 'text-center', render: data => data ? '⭐' : '' }
            ,   { data: 'with_freight', className: 'text-center', render: data => data ? '🚚' : '' }
            ,   { data: 'promotions_count', render: count => number_format(count) }
            ,   { data: 'gallery_count', render: count => number_format(count) }
            ,   { data: 'preview', className: 'text-center' }
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
