import {DT_OPTIONS_SSR, date_time_format} from './common.js'

$(document).ready(function() {
    $('#roles-table').DataTable({
            ...DT_OPTIONS_SSR
        ,   ajax:                   {
                ...DT_OPTIONS_SSR.ajax
            ,   url:                url_route
        }
        ,   columns:                [
                ...DT_OPTIONS_SSR.columns
            ,   { data: 'name', render: name => { return name.toUpperCase(); } }
            ,   { data: 'permissions' }
            ,   { data: 'created_at', render: created_at => { return date_time_format(created_at) }, className: 'text-right' }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
