import {DT_OPTIONS_SSR, set_human_datetime} from './common.js'

$(document).ready(function() {
    $('#branches-table').DataTable({
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
                        data:       null
                    ,   render:     ({street, number, neighborhood, building}) => {
                            let with_building = building
                                ? `<strong>${building}</strong><br>`
                                : ''
                            return `${with_building} ${street} núm. ${number},<br> Col. ${neighborhood}`
                    }
                }
            ,   { data: 'city_name' }
            ,   { data: 'state_name' }
            ,   { data: 'country' }
            ,   { data: 'phone' }
            ,   {
                        data:       null
                    ,   className:  'text-right'
                    ,   render:     data => set_human_datetime(data)
                }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
