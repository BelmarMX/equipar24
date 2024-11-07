import { DT_OPTIONS_SSR } from './common.js'

$(document).ready(function() {
    $('#contactList-table').DataTable({
            ...DT_OPTIONS_SSR
        ,   ajax:                   {
                ...DT_OPTIONS_SSR.ajax
            ,   url:                route
        }
        ,   columns:                [
                ...DT_OPTIONS_SSR.columns
            ,   { data: 'name' }
            ,   { data: 'email' }
            ,   { data: 'phone' }
            ,   { data: 'company' }
            ,   { data: 'state_name' }
            ,   { data: 'city_name' }
            ,   {
                        data:       null
                    ,   className:  'text-right'
                    ,   render:     ({human_created_at, created_dmy}) => {
                            return `<small class="human-date" data-tooltip="Creado ${created_dmy}">${human_created_at}</small>`
                        }
                }
        ]
    })
})
