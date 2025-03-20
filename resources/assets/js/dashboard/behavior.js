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
import SimpleImage                          from "@editorjs/simple-image";
import Paragraph                            from 'editorjs-paragraph-with-alignment';
import Table                                from "@editorjs/table";
import Plyr                                 from "plyr";
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
    /* --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    * CLICK EVENTS
    --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- */
    $(document).on('click', '[data-lightbox]', function(e) {
        e.preventDefault()

        let title = $(this).attr('data-title') ? $(this).attr('data-title') : 'Vista previa'
        Alert.ligthbox($(this).attr('data-lightbox'), title)
    })

    $(document).on('click', '[data-lightbox-embed]', function(e) {
        e.preventDefault()

        let title   = $(this).attr('data-title') ? $(this).attr('data-title') : 'Vista previa'
        let src     = $(this).attr('data-lightbox-embed')
        Alert.html(`<embed src="${src}" class="w-full" style="min-height: 80vh;">`, title, true)
    })

    $(document).on('click', '[data-lightbox-video]', function(e){
        e.preventDefault()
        let html    = `<div class="w-full">
            <video class="js-player mx-auto" playsinline controls muted>
                <source src="${ $(this).attr('data-lightbox-video') }"/>
            </video>
        </div>`
        Alert.html(html, 'Reel')
        const player = Plyr.setup('.js-player', { controls: ['play-large', 'restart', 'play', 'progress', 'current-time', 'duration','mute', 'volume', 'fullscreen'] });
    })

    $(document).on('click', '[data-confirm-redirect]', function(e) {
        e.preventDefault()
        let attribute   = $(this).attr('data-confirm-redirect')
        let ask         = attribute !== '' ? attribute : '¿Estás seguro de realizar esta acción?'
        Alert.confirm('Perderás los cambios que no hayas guardado', () => location.href = $(this).attr('href'), ask )
    })

    $(document).on('keydown', '[data-feature-input-source]', function(e) {
        if( e.key === 'Enter' )
        {
            e.preventDefault()
            $(this).parents('div').find('[data-feature-action-add]').click()
        }
    })
    $(document).on('click', '[data-feature-action-add]', function(e) {
        let wrapper         = $(this).parents('[data-features-wrapper]')
        let input_source    = $(this).parents('div').find('[data-feature-input-source]')
        let raw_container   = wrapper.find('[data-features-raw]')

        if( input_source.val() === '' )
        {
            Alert.error('Debes agregar una característica', 'Este campo es requerido')
            return
        }

        wrapper.find('[data-features-control]').prepend(`<div class="relative flex items-center mt-2">
                <button type="button"
                        class="absolute right-2 focus:outline-none rtl:left-0 rtl:right-auto text-red-400 hover:text-red-600"
                        data-feature-action-remove
                >
                    <i class="fa-solid fa-trash"></i>
                </button>
                <input type="text"
                       placeholder="Característica"
                       class="block w-full pt-3 pb-2 p-2 mt-0 bg-gray-50 hover:bg-gray-100 border-0 border-b-2 border-violet-50 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700"
                       value="${input_source.val().replaceAll('"', "&quot;")}"
                       data-feature-item
                >
            </div>`)
        .val()

        raw_container.val(raw_container.val()+'|'+input_source.val())
        input_source.val('')
        input_source.focus()
    })

    $(document).on('focusout', '[data-feature-item]', function(e) {
        let wrapper         = $(this).parents('[data-features-wrapper]')
        let raw_container   = wrapper.find('[data-features-raw]')
        let all_items       = $($('[data-feature-item]').get().reverse())
        let new_value       = ''
        all_items.each((i, el) => {
            new_value = new_value !== ''
                ? new_value +'|'+el.value
                : el.value
        })

        raw_container.val(new_value)
    })

    $(document).on('click', '[data-feature-action-remove]', function(e) {
        let wrapper         = $(this).parents('[data-features-wrapper]')
        let raw_container   = wrapper.find('[data-features-raw]')
        let features        = []

        $(this).parent('div').remove()

        wrapper.find('[data-features-control]').find('div').map((i, el) => {
            features.push($(el).find('[data-feature-item]').val())
        })

        raw_container.val(features.reverse().join('|'))
    })


    /* --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    * FOCUS OUT EVENTS
    --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- */
    $('[load-iframe]').on('focusout', function() {
        let iframe_id   = $(this).attr('load-iframe');
        let value       = $(this).find('input').val()

        $(iframe_id).attr('src', value)
    })


    /* --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    * CHANGE EVENTS
    --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- */
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

    $('[data-category-fill]').on('change', function() {
        let category_id         = $(this).find('select').val();
        let subcategories_el    = $(this).attr('data-category-fill');

        axios.post('/productos/subcategorias'
            ,   {
                category_id: category_id
            })
            .then(({data}) => {
                $(subcategories_el).empty()
                $(subcategories_el).append(`<option selected>Subcategoría</option>`)
                data.forEach(subcategory => {
                    $(subcategories_el).append(`<option value="${subcategory.id}">${subcategory.title}</option>`)
                })
            })
            .catch(error => {
                console.error('Subcategories Error', error)
            })
    })

    $('[data-subcategory-fill]').on('change', function() {
        let category_id         = $('[data-category-fill]').find('select').val();
        let subcategory_id      = $(this).find('select').val();
        let products_el         = $(this).attr('data-subcategory-fill');

        axios.post('/productos/filtrados'
            ,   {category_id, subcategory_id}
        )
            .then(({data}) => {
                $(products_el).empty()
                $(products_el).append(`<option selected>Producto</option>`)
                data.forEach(product => {
                    $(products_el).append(`<option value="${product.id}"
                        data-link-href="${product.asset_url.replace('storage/', '')}${product.product_category.slug}/${product.product_subcategory.slug}/${product.slug}"
                        data-link-title="${product.model}"
                        data-link-description="${product.title}"
                    >${product.title}</option>`)
                })
            })
            .catch(error => {
                console.error('Products Error', error)
            })
    })

    $('[data-clear-errors]').on('change', function(e) {
        $(this).parent('div').find('.is-invalid').addClass('hidden')
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

    $(document).on('change', '[data-preview-file]', function(e) {
        let target  = $(this).attr('data-preview-file')
        let files   = e.target.files
        if( files[0] )
        {
            let reader      = new FileReader();
            reader.onload   = function(e) {
                $(target).removeClass('hidden')
                $(target).parent().find('.svg_load_icon').addClass('hidden')
                $(target).parent().find('.metadata').removeClass('hidden').text(files[0].name)
                $(target).find('embed').attr('src', e.target.result);
            }
            reader.readAsDataURL(files[0]);
        }
    })


    /* --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    * FRONT END EFFECTS
    --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- */
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


    /* --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    * INIT FUNCTIONS
    --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- */
    if( typeof $().select2 === 'function' )
    {
        $('.select-2').select2({ language: "es" })
    }

    $('input[data-range]').map((i, el) => {
        let min_date = $(el).attr('data-range-min_date') || $(el).val().split(' - ')[0]
        $(el).daterangepicker({
                locale:             { ...RANGE_LOCALE }
            ,   minDate:            min_date ? new Date(min_date) : new Date()
        })
    })
    $('input[data-range]').on('apply.daterangepicker', function(ev, picker) {
        $( $(this).attr('data-range-set_start') ).val(picker.startDate.format('YYYY-MM-DD'))
        $( $(this).attr('data-range-set_end') ).val(picker.endDate.format('YYYY-MM-DD'))
    })

    let date_value = $('[data-date-picker]').attr('data-min_date')
    flatpickr('[data-date-picker]', {
            locale:         Spanish
        ,   altInput:       true
        ,   altFormat:      "j F, Y"
        ,   dateFormat:     "Y-m-d"
        ,   minDate:        date_value || "today"
    })

    if( document.getElementById('editorjs') )
    {
        const editor = new EditorJS({
                holder:         'editorjs'
            ,   autofocus:      false
            ,   inlineToolbar:  ['link', 'bold', 'italic']
            ,   tools:          {
                    image:      {
                            class:          ImageTool
                        ,   config:         {
                                captionPlaceholder:     'Agrega una descripción'
                            ,   uploader:               {
                                uploadByFile(file)
                                {
                                    let form_data           = new FormData();
                                    form_data.append('archivo', file)
                                    return axios.post('/dashboard/upload_file', form_data, {
                                        headers: {
                                            'Content-Type': 'multipart/form-data'
                                        }
                                    })
                                        .then(({status, data}) => {
                                            console.log(data)
                                            return data
                                        })
                                }
                            }
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
            ,   onReady:        async O => {
                console.log('Editor is ready!')
                if( $('#raw_editor').val() !== '' )
                {
                    await editor.render(JSON.parse($('#raw_editor').val()))
                }
                else if (editor_data_html)
                {
                    await editor.blocks.renderFromHTML(editor_data_html);
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

    /* --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    * DOWN LOADER
    --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- */
    working(false)
})
