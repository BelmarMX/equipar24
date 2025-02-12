import { DT_OPTIONS_SSR } from './common.js'

$(document).ready(function() {
    $('#cities-table').DataTable({
            ...DT_OPTIONS_SSR
        ,   ajax:                   {
                ...DT_OPTIONS_SSR.ajax
            ,   url:                route
        }
        ,   columns:                [
                ...DT_OPTIONS_SSR.columns
            ,   { data: 'state_name' }
            ,   { data: 'name' }
            ,   {
                        data:       null
                    ,   className:  'text-right'
                    ,   render:     ({human_created_at, created_dmy}) => {
                            return `<small class="human-date" data-tooltip="Creado ${created_dmy}">${human_created_at}</small>`
                        }
                }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
