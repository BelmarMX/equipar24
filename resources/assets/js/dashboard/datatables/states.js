import { DT_OPTIONS_SSR } from './common.js'

$(document).ready(function() {
    $('#states-table').DataTable({
            ...DT_OPTIONS_SSR
        ,   ajax:                   {
                ...DT_OPTIONS_SSR.ajax
            ,   url:                '/dashboard/states'
        }
        ,   columns:                [
                ...DT_OPTIONS_SSR.columns
            ,   { data: 'code' }
            ,   { data: 'alias' }
            ,   { data: 'name' }
            ,   { data: 'variant' }
            ,   { data: 'ciudades_count' }
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
