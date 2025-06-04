import { number_format, esc_html } from './common.js'
import Alerts from "../alerts.js"
$(document).ready(function() {
    /* -----------------------------------------------------------------------------------------------------------------
     * Recalcular precios de la cotización.
    ----------------------------------------------------------------------------------------------------------------- */
    const recalculate           = O => {
        let gran_total          = 0
        let original            = 0
        $('[data-product_id]').each((i, tr) => {
            let product_id      = $(tr).data('product_id')
            let in_stock        = $('[name="quotation.in_stock['+product_id+']"]').val() === "1"
            let is_deleted      = $('[name="quotation.is_deleted['+product_id+']"]').val() === "1"

            if( !in_stock || is_deleted )
            { return }

            let quantity        = parseFloat($('[name="quotation.quantity['+product_id+']"]').val())
            let total           = parseFloat($('[name="quotation.total['+product_id+']"]').val())
            let original_price  = parseFloat($('[name="quotation.original['+product_id+']"]').val())
            let total_product   = quantity * total
            gran_total          += total_product
            original            += original_price

            $('[data-update-amount="'+product_id+'"]').text(`$${number_format(total_product)}`)
        })

        console.log(original)
        $('[data-original-price]').text(`$${number_format(original)}`)
        $('[data-gran-total]').text(`$${number_format(gran_total)}`)
    }

    /* -----------------------------------------------------------------------------------------------------------------
     * Cambiar cantidad del producto
    ----------------------------------------------------------------------------------------------------------------- */
    $(document).on('change', '[data-table="quantity"]', function(e){
        recalculate()
    })

    /* -----------------------------------------------------------------------------------------------------------------
     * Marcar producto sin existencias.
    ----------------------------------------------------------------------------------------------------------------- */
    $(document).on('click', '[data-no-stock]', function(e) {
        e.preventDefault()
        const product_id        = $(this).attr('data-no-stock')
        const this_btn          = $(this)
        const disabled          = $(document).find('tr[data-product_id]:not(.bg-red-50):not(.bg-red-100)').length

        if( disabled <= 1 )
        {
            return Alerts.warning('La cotización debe tener por lo menos un producto activo', '¡Cuidado!')
        }

        Alerts.confirm(`El producto ${product_id} será marcado sin existencias y no podrá ser restaurado en la cotización.`, O => {
            this_btn.remove()
            $('[data-product_id="'+product_id+'"]').addClass('bg-red-50')
            $('[data-if-not-stock="'+product_id+'"]').html('')
            $('[data-delete="'+product_id+'"]').remove()
            $('[data-restore="'+product_id+'"]').remove()

            $('[name="quotation.in_stock['+product_id+']"]').val(0)
            $('[name="quotation.is_deleted['+product_id+']"]').val(1)

            recalculate()
        })
    })

    /* -----------------------------------------------------------------------------------------------------------------
     * Eliminar producto de la cotización.
    ----------------------------------------------------------------------------------------------------------------- */
    $(document).on('click', '[data-delete]', function(e) {
        e.preventDefault()
        const product_id        = $(this).attr('data-delete')
        const btn_delete        = $(this)
        const disabled          = $(document).find('tr[data-product_id]:not(.bg-red-50):not(.bg-red-100)').length

        if( disabled <= 1 )
        {
            return Alerts.warning('La cotización debe tener por lo menos un producto activo', '¡Cuidado!')
        }

        Alerts.confirm(`El producto ${product_id} será eliminado de la cotización.`, O => {
            btn_delete.addClass('hidden')
            $('[data-restore="'+product_id+'"]').removeClass('hidden')
            $('[data-product_id="'+product_id+'"]').addClass('bg-red-100')
            $('[name="quotation.quantity['+product_id+']"]').attr('readonly', 'readonly')

            $('[name="quotation.is_deleted['+product_id+']"]').val(1)

            recalculate()
        })
    })

    /* -----------------------------------------------------------------------------------------------------------------
     * Restaurar producto de la cotización.
    ----------------------------------------------------------------------------------------------------------------- */
    $(document).on('click', '[data-restore]', function(e) {
        e.preventDefault()
        const product_id    = $(this).attr('data-restore')
        const btn_restore   = $(this)

        Alerts.confirm(`Se restaurará el producto ${product_id} en la cotización.`, O => {
            btn_restore.addClass('hidden')
            $('[data-delete="'+product_id+'"]').removeClass('hidden')
            $('[data-product_id="'+product_id+'"]').removeClass('bg-red-100')
            $('[name="quotation.quantity['+product_id+']"]').removeAttr('readonly')

            $('[name="quotation.is_deleted['+product_id+']"]').val(0)

            recalculate()
        })
    })

    /* -----------------------------------------------------------------------------------------------------------------
     * Enviar mensaje de whatsapp con el detalle de la cotización.
    ----------------------------------------------------------------------------------------------------------------- */
    $('#send_whatsapp').on('click', function(e){
        let phone   = $('[data-field="contact_phone"] > input').val()
        let nombre  = $('[data-field="contact_name"] > input').val()
        let tabla   = ''
        $('.quotation > tr:not(.ignore)').each((i, el) => {
            let in_stock        = $('[name="quotation.in_stock['+$(el).data('product_id')+']"]').val() === "1"
            let is_deleted      = $('[name="quotation.is_deleted['+$(el).data('product_id')+']"').val() === "1"
            let qty             = $(el).find('[data-table="quantity"]').val()
            if( !in_stock || is_deleted )
            {
                qty = '0'
            }
            let product         = $(el).find('[data-table="title"]').text()
            tabla               += `${qty} x ${product}${ !in_stock || is_deleted ? ' (No disponible)' : ''}`+"\n"
        })
        tabla       = encodeURI(tabla.replaceAll('&', '').replaceAll('%', '').replaceAll('?', ''))
        let message = `https://api.whatsapp.com/send?phone=521${phone}&text=Estimado/a%20${nombre}%0A%0A¡Gracias%20por%20contactar%20a%20Equi-par%20y%20por%20tu%20interés%20en%20nuestros%20productos!%20Antes%20de%20enviarte%20la%20cotización%20final,%20queremos%20asegurarnos%20de%20que%20la%20información%20proporcionada%20sea%20correcta%20y%20confirmar%20algunos%20detalles%20contigo.%0A%0AAdjunto%20encontrarás%20un%20resumen%20de%20los%20productos%20que%20has%20solicitado.%20Además,%20queremos%20informarte%20que%20algunos%20de%20ellos%20podrían%20no%20estar%20disponibles%20en%20este%20momento.%20Sin%20embargo,%20contamos%20con%20opciones%20similares%20que%20cumplen%20con%20las%20mismas%20características%20y%20que%20podrían%20interesarte.%0A%0A${tabla}%0APor%20favor,%20revisa%20la%20información%20y%20confírmanos%20si%20todo%20es%20correcto%20o%20si%20deseas%20considerar%20las%20alternativas%20que%20podemos%20ofrecerte.%20Estaremos%20encantados%20de%20ajustarnos%20a%20tus%20necesidades.%0A%0AQuedamos%20atentos%20a%20tu%20respuesta.`
        window.open(message, '_blank')
    })

    /* -----------------------------------------------------------------------------------------------------------------
     * Consultar productos que coincidan
    ----------------------------------------------------------------------------------------------------------------- */
    $(document).on('keydown', '#search_title', function(e){
        if(e.key === 'Enter')
        {
            e.preventDefault();
            $('[data-search-product]').click()
        }
    })
    $(document).on('click', '[data-search-product]', function(e){
        e.preventDefault()

        $(this).find('.working').removeClass('hidden')
        $(this).find('.static').addClass('hidden')
        $('#results').html(`<option selected="" disabled>Selecciona uno de la lista</option>`)

        axios.post('/productos/autocomplete', {
            query: $('#search_title').val()
        })
            .then(({data}) => {
                if( !data )
                {
                    $('[data-show="results_not_found"]').removeClass('hidden')
                    $('[data-show="results_found"]').addClass('hidden')
                }
                $('[data-show="results_not_found"]').addClass('hidden')
                $('[data-show="results_found"]').removeClass('hidden')

                data.sort((a, b) => a.title.localeCompare(b.title))
                data.forEach(item => {
                    console.log(item.promotion)
                    $('#results').append(`<option value="${item.id}"
                                                    data-title="${esc_html(item.title)}"
                                                    data-original_price="${item.price}"
                                                    data-discount="${item.price - item.final_price}"
                                                    data-total="${item.final_price}"
                                                    data-with_freight="${item.con_flete}"
                                                    data-title="${item.title}"
                                                    data-model="${item.model}"
                                                    data-brand="${item.brand}"
                                                    data-image="${item.image_path}"
                                                    data-promotion="${item.promotion}"
                    >(${item.id}) ${item.brand} :: ${item.title} | $${number_format(item.final_price)}<option>`)
                })
            })
            .catch(error => console.error(error))
            .finally(O => {
                $(this).find('.working').addClass('hidden')
                $(this).find('.static').removeClass('hidden')
            })
    })

    $(document).on('click', '#add_new_product_to_quota', function(e){
        e.preventDefault()

        let selected    = $('#results > option:selected')
        let product_id  = selected.val()
        let quantity    = $('#new_quantity').val()

        $('tbody.quotation tr.totales').before(`<tr class="border-b border-neutral-200" data-product_id="${product_id}">
            <td class="px-3 py-2 text-right">
                <button type="button" data-tooltip="Marcar sin existencia" data-no-stock="${product_id}">🔴</button>
                <small>${product_id}</small>
                <input type="hidden" name="quotation.product_id[]" value="${product_id}">
                <input type="hidden" name="quotation.original[${product_id}]" value="${selected.data('original_price')}">
                <input type="hidden" name="quotation.discount[${product_id}]" value="${selected.data('discount')}">
                <input type="hidden" name="quotation.total[${product_id}]" value="${selected.data('total')}">
                <input type="hidden" name="quotation.in_stock[${product_id}]" value="1">
                <input type="hidden" name="quotation.is_deleted[${product_id}]" value="0">
                <input type="hidden" name="quotation.add_after[${product_id}]" value="1">
                <input type="hidden" name="quotation.title[${product_id}]" value="${selected.data('title')}">
                <input type="hidden" name="quotation.model[${product_id}]" value="${selected.data('model')}">
                <input type="hidden" name="quotation.brand[${product_id}]" value="${selected.data('brand')}">
                <input type="hidden" name="quotation.image[${product_id}]" value="${selected.data('image')}">
            </td>
            <td class="px-3 py-2" style="max-width: 430px">
                <small data-table="title">${selected.data('title')}</small>
            </td>
            <td class="px-3 py-2" data-if-not-stock="${product_id}">
                ${selected.data('promotion')}
            </td>
            <td class="px-3 py-2 text-right" data-if-not-stock="${product_id}">
                <input data-table="quantity" type="number" min="1" name="quotation.quantity[${product_id}]" value="${quantity}" class="block pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700 text-right" style="max-width: 80px;">
            </td>
            <td class="px-3 py-2 text-right" data-if-not-stock="${product_id}">$${number_format(selected.data('original_price'))}</td>
            <td class="px-3 py-2 text-right" data-if-not-stock="${product_id}">$${number_format(selected.data('discount'), true)}</td>
            <td class="px-3 py-2 text-right" data-if-not-stock="${product_id}">$${number_format(selected.data('total'))}</td>
            <td class="px-3 py-2 text-right" data-if-not-stock="${product_id}" data-update-amount="${product_id}">$${number_format(quantity * selected.data('total'))}</td>
            <td class="text-center">
                <button class="text-red-500" data-tooltip="Eliminar de la cotización" data-delete="${product_id}">
                    <i class="fa-solid fa-trash"></i>
                </button>
                <button class="text-sky-500 hidden" data-tooltip="Restaurar en la cotización" data-restore="${product_id}">
                    <i class="fa-solid fa-trash-restore"></i>
                </button>
            </td>
        </tr>`)

        selected.remove()
        $('#results').val(null)
        $('#new_quantity').val(1)

        recalculate()
    })

    /* -----------------------------------------------------------------------------------------------------------------
     * Completar venta
    ----------------------------------------------------------------------------------------------------------------- */
    $(document).on('click', '#update_sold_status', function(e){
        $('[data-loader]').removeClass('hidden')

        axios.post('sold/'+$(this).attr('data-form-id')+'/update', {
            is_sold: $('#is_sold').val()
        })
            .then(({data}) => {
                console.log('finished change', data)
            })
            .catch(error => console.error(error))
            .finally(O => {
                $('[data-loader]').addClass('hidden')
            })
    })
})
