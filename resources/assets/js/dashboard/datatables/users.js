import {DT_OPTIONS_SSR, number_format, set_human_datetime} from './common.js'

$(document).ready(function() {
    $('#users-table').DataTable({
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
            ,   { data: 'email' }
            ,   { data: 'name' }
            ,   { data: 'email_verified_at', render: verified => { return !verified ? 'No' : 'Sí'  } }
            ,   { data: 'roles' }
            ,   { data: 'permissions' }
            ,   {
                    data:       null
                ,   className:  'text-right'
                ,   render:     data => set_human_datetime(data)
            }
            ,   { data: 'action', className: 'text-center' }
        ]
    })
})
