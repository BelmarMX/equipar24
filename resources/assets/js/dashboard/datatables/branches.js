import { DT_OPTIONS_SSR } from './common.js'

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
                    ,   render:     ({human_created_at, created_dmy, deleted_at}) => {
                            let is_deleted = deleted_at !== null
                                ? `<br><small class="bg-red-500 text-white p-1 rounded">ELIMINADO</small>`
                                : ''
                            return `${created_dmy}<br><small class="human-date">${human_created_at}</small>${is_deleted}`
                        }
                }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
