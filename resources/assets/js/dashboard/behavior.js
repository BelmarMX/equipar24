import axios                                from "axios"
import Alert                                from "./alerts"
import flatpickr                            from "flatpickr"
import { Spanish }                          from "flatpickr/dist/l10n/es.js";
import EditorJS                             from "@editorjs/editorjs";
import AttachesTool                         from "@editorjs/attaches";
import Delimiter                            from "@editorjs/delimiter";
import Embed                                from "@editorjs/embed";
import Header                               from "editorjs-header-with-alignment";
import ImageTool                            from "@editorjs/image";
import LinkTool                             from "@editorjs/link";
import List                                 from '@editorjs/list';
import Paragraph                            from 'editorjs-paragraph-with-alignment';
import Table                                from "@editorjs/table";
import Title                                from "title-editorjs";
import {URL_PARAMS, RANGE_LOCALE}           from "./datatables/common.js"

const working                               = activate => {
    if( activate)
    {
        $('[data-loader]').removeClass('hidden')
    }
    else
    {
        $('[data-loader]').addClass('hidden')
    }
}

const toast_created                         = title => {
    Alert.toast(title)
}

const clear_path_name                       = O => {
    let url     = new URL(window.location.href)
    let params  = new URLSearchParams(url.search)
    params.forEach((value, key) => {
        params.delete(key);
    })
    window.history.replaceState({}, document.title, url.pathname);
}

$(document).ready(function() {
    if( typeof $().select2 === 'function' )
    {
        $('.select-2').select2({ language: "es" })
    }

    $('[data-state-fill]').on('change', function() {
        let state_id    = $(this).find('select').val();
        let cities_el   = $(this).attr('data-state-fill');

        axios.post('/contacto/cities'
            ,   {
                state_id: state_id
            })
            .then(({data}) => {
                $(cities_el).empty()
                $(cities_el).append(`<option selected>Ciudad</option>`)
                data.forEach(city => {
                    $(cities_el).append(`<option value="${city.id}">${city.name}</option>`)
                })
            })
            .catch(error => {
                console.error('Cities Error', error)
            })
    })

    $('[load-iframe]').on('focusout', function() {
        let iframe_id   = $(this).attr('load-iframe');
        let value       = $(this).find('input').val()

        $(iframe_id).attr('src', value)
    })

    $('[data-clear-errors]').on('change', function(e) {
        $(this).parent('div').find('.is-invalid').addClass('hidden')
    })

    $(document).on('click', '[data-lightbox]', function(e) {
        e.preventDefault()

        let title = $(this).attr('data-title') ? $(this).attr('data-title') : 'Vista previa'
        Alert.ligthbox($(this).attr('data-lightbox'), title)
    })

    $(document).on('click', '[data-confirm-redirect]', function(e) {
        e.preventDefault()
        let attribute   = $(this).attr('data-confirm-redirect')
        let ask         = attribute !== '' ? attribute : '¿Estás seguro de realizar esta acción?'
        Alert.confirm('Perderás los cambios que no hayas guardado', () => location.href = $(this).attr('href'), ask )
    })

    $(document).on('change', '[data-preview-image]', function(e) {
        let target  = $(this).attr('data-preview-image')
        let files   = e.target.files
        if( files[0] )
        {
            let reader      = new FileReader();
            reader.onload   = function(e) {
                $(target).removeClass('hidden')
                $(target).parent().find('.svg_load_icon').addClass('hidden')
                $(target).parent().find('.metadata').removeClass('hidden').text(files[0].name)
                $(target).find('.image_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(files[0]);
        }
    })

    if( URL_PARAMS.get('created') )
    {
        Alert.toast('Registro creado con éxito')
        clear_path_name()
    }
    if( URL_PARAMS.get('updated') )
    {
        Alert.toast('Registro actualizado con éxito')
        clear_path_name()
    }
    if( URL_PARAMS.get('restored') )
    {
        Alert.toast('Registro restaurado con éxito')
        clear_path_name()
    }
    if( URL_PARAMS.get('deleted') )
    {
        Alert.toast('Registro eliminado con éxito')
        clear_path_name()
    }
    if( URL_PARAMS.get('error') )
    {
        Alert.toast('Lo sentimos: algo salió mal', 'error')
        clear_path_name()
    }

    $('input[data-range]').map((i, el) => {
        $(el).daterangepicker({
                locale:             { ...RANGE_LOCALE }
            ,   minDate:            $(el).val() ? $(el).val().split(' - ')[0] : new Date()
        })
    })
    $('input[data-range]').on('apply.daterangepicker', function(ev, picker) {
        $( $(this).attr('data-range-set_start') ).val(picker.startDate.format('YYYY-MM-DD'))
        $( $(this).attr('data-range-set_end') ).val(picker.endDate.format('YYYY-MM-DD'))
    })

    flatpickr('[data-date-picker]', {
            locale:         Spanish
        ,   altInput:       true
        ,   altFormat:      "j F, Y"
        ,   dateFormat:     "Y-m-d"
        ,   minDate:        "today"
    })
    if( document.getElementById('editorjs') )
    {
        const editor = new EditorJS({
                holder:         'editorjs'
            ,   autofocus:      false
            ,   inlineToolbar:  ['link', 'bold', 'italic']
            ,   tools:          {
                    attaches:       {
                            class:          AttachesTool
                        ,   config:         {
                                endpoint:               '/dashboard/upload_file'
                            ,   field:                  'file'
                            ,   types:                  '*'
                            ,   additionalRequestData:  { "_token": $('meta[name="csrf-token"]').attr('content') }
                            ,   onUploadResponse:       ({success, file}) => { success, file }
                        }
                    }
                ,   delimiter:      Delimiter
                ,   embed:          Embed
                ,   header:         {
                            class:          Header
                        ,   inlineToolbar:  true
                        ,   config:         {
                                placeholder:        'Agrega un título'
                            ,   levels:             [2, 3, 4, 5, 6]
                            ,   defaultLevel:       2
                            ,   defaultAlignment:   'left'
                        }
                    }
                ,   list:           List
                ,   paragraph:      {class: Paragraph, inlineToolbar: true}
                ,   table:          Table
            }
            ,   data:           {}
            ,   placeholder:    'Comienza a escribir o pega el contenido del artículo...'
            ,   onReady:        O => {
                console.log('Editor is ready!')
                if( $('#raw_editor').val() !== '' )
                {
                    editor.render(JSON.parse($('#raw_editor').val()))
                }
            }
            ,   onChange:       (api, event) => {
                editor
                    .save()
                    .then(result => {
                        $('#raw_editor').val(JSON.stringify(result))
                        console.log('Article content', result)
                    })
                    .catch(error => console.error('Article content error', error))
            }
        })
    }
    working(false)
})
