const DT_LANG_ES            = "https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-MX.json"

const URL_PARAMS            = new URLSearchParams(window.location.search)

const DT_OPTIONS            = {
        language:           {
                url:            DT_LANG_ES
            ,   lengthMenu:     "Viendo _MENU_ registros por página"
            ,   zeroRecords:    "No se encontraron registros"
            ,   info:           "Mostrando _START_ a _END_ de _TOTAL_ registros"
            ,   infoFiltered:   "(Filtrado de _MAX_ registros en total)"
            ,   paginate:       {
                    previous:       '<svg xmlns="http://www.w3.org/2000/svg" height="10" width="6.25" viewBox="0 0 320 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>'
                ,   next:           '<svg xmlns="http://www.w3.org/2000/svg" height="10" width="6.25" viewBox="0 0 320 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>'
            }
        }
    ,   lengthMenu:         [
            [32, 64, 128, 256, 512, -1]
        ,	[32, 64, 128, 256, 512, "Todos"]
    ]
    ,   layout:             {
            bottomEnd:          {
                paging:             {
                    firstLast:          false
                }
            }
    }
    ,   stateSave:          true
    ,   fixerHeader:        true
    ,   scrollCollapse:     true
    ,   scrollY:            "65vh"
    //,   scrollX:            "100vw"
    ,   pageLength:         64
    ,   responsive:         true
    ,   searching:          true
    ,   retrieve:           true
}

const DT_OPTIONS_SSR        = {
        ...DT_OPTIONS
    ,   processing:         true
    ,   serverSide:         true
    ,   ajax:               {
            method:             'POST'
        ,   headers:            {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        ,   url:                ''
    }
    ,   columns:            [
        {
                data:       'id'
            ,   render:     id => {
                if(URL_PARAMS.get('created') && parseInt(URL_PARAMS.get('created')) === id)
                {
                    return `<i class="fa-regular fa-circle-dot fa-beat me-1 text-green-500" data-tooltip="Creado recientemente"></i> ${id}`
                }
                else if(URL_PARAMS.get('updated') && parseInt(URL_PARAMS.get('updated')) === id || URL_PARAMS.get('restored') && parseInt(URL_PARAMS.get('restored')) === id)
                {
                    return `<i class="fa-regular fa-circle-dot fa-beat me-1 text-blue-500" data-tooltip="Actualizado recientemente"></i> ${id}`
                }
                else if(URL_PARAMS.get('deleted') && parseInt(URL_PARAMS.get('deleted')) === id)
                {
                    return `<i class="fa-regular fa-circle-dot fa-beat me-1 text-red-500" data-tooltip="Eliminado recientemente"></i> ${id}`
                }

                return id
            }
            ,   type:       "num"
        }
    ]
    ,   order:              {
            idx: 0
        ,   dir: 'desc'
    }
}

const RANGE_LOCALE          = {
        format:             'DD/MM/YYYY'
    ,   separator:          ' - '
    ,   applyLabel:         'Aplicar'
    ,   cancelLabel:        'Cancelar'
    ,   fromLabel:          'Desde'
    ,   toLabel:            'Hasta'
    ,   customRangeLabel:   'Personalizado'
    ,   weekLabel:          'S'
    ,   daysOfWeek:         [
                'Do'
            ,   'Lu'
            ,   'Ma'
            ,   'Mi'
            ,   'Ju'
            ,   'Vi'
            ,   'Sa'
        ]
    ,   monthNames:         [
                'Enero'
            ,   'Febrero'
            ,   'Marzo'
            ,   'Abril'
            ,   'Mayo'
            ,   'Junio'
            ,   'Julio'
            ,   'Agosto'
            ,   'Septiembre'
            ,   'Octubre'
            ,   'Noviembre'
            ,   'Diciembre'
        ]
    ,   firstDay:           1
}

const set_human_datetime    = ({human_created_at, created_dmy, deleted_at}) => {
    let is_deleted = deleted_at !== null
        ? `<br><small class="bg-red-500 text-white p-1 rounded">ELIMINADO</small>`
        : ''
    return `${created_dmy}<br><small class="human-date">${human_created_at}</small>${is_deleted}`
}

export { DT_OPTIONS, DT_OPTIONS_SSR, URL_PARAMS, set_human_datetime, RANGE_LOCALE }
