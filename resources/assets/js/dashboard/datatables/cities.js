import { DT_OPTIONS_SSR } from './common.js'

$(document).ready(function() {
    $('#cities-table').DataTable({
            ...DT_OPTIONS_SSR
        ,   ajax:                   {
                ...DT_OPTIONS_SSR.ajax
            ,   url:                route
        }
        ,   columns:                [
                { data: 'id' }
            ,   { data: 'state_name' }
            ,   { data: 'name' }
            ,   {
                        data:       null
                    ,   className:  'text-right'
                    ,   render:     ({human_created_at, created_dmy}) => {
                            return `${created_dmy}<br><small class="human-date">${human_created_at}</small>`
                        }
                }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
