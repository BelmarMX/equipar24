import Swal from "sweetalert2";

// Agregar productos al cotizador
document
    .querySelectorAll('[data-quote-add]')
    .forEach(element => {
        element.addEventListener('click', function() {
            let product         = JSON.parse(this.getAttribute('data-quote-add'))
            let product_stored  = JSON.parse(localStorage.getItem('products'))
            if( !product_stored )
            {
                product_stored = []
            }

            let mod_cant = false
            product_stored      = product_stored.map( stored_product => {
                if( stored_product.id === product.id )
                {
                    mod_cant = true
                    stored_product.cant = stored_product.cant + 1
                }
                return stored_product
            })

            let to_store = [
                ...product_stored
            ]
            if( !mod_cant )
            {
                to_store.push({
                    ...product,
                    cant: 1
                })
            }

            console.log(to_store)

            localStorage.setItem('products', JSON.stringify(to_store))

            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: `${product.title} agregado al cotizador`
            })

            document.getElementById('link_quotation')
                .classList
                .remove('empty')
        })
    })

// Llenado de la tabla de productos en el formulario
if( document.getElementById('quotation-table') )
{
    if( JSON.parse( localStorage.getItem('products') ) && JSON.parse( localStorage.getItem('products') ).length > 0 )
    {
        let products    = JSON.parse( localStorage.getItem('products') )
        let html        = ''
        products.map((product, index) => {
            html += `<tr data-quote-tr_index="${index}">
                <td class="pt-3">
                    <div class="position-relative mb-1 w-75 p-0 mx-auto">
                        <input type="hidden" name="id[]" value="${product.id}">
                        <label class="form-label" style="left:23px">Cant</label>
                        <input data-quote-update="${product.id}"
                            name="qty[${product.id}][]"
                            class="form-control text-center"
                            type="number"
                            min="1"
                            value="${product.cant}"
                            required
                        >
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <img width="60"
                                height="60"
                                class="img-fluid"
                                src="${product.image}"
                                alt="Vista previa"
                            >
                        </div>
                        <div>
                            <strong>${product.model}</strong><br>
                            <small>${product.title}</small>
                        </div>
                    </div>
                </td>
                <td class="pt-3">
                    <button data-quote-remove="${product.id}"
                        data-quote-index="${index}"
                        data-bs-toggle="tooltip"
                        title="Quitar producto del cotizador"
                        class="btn btn-danger"
                    >
                        <i class="bi bi-trash text-white"></i>
                    </button>
                </td>
            </tr>`
        })

        document.getElementById('quotation-table').innerHTML = html
    }
    else
    {
        document.getElementById('send_form').setAttribute('hidden', 'hidden')
        document.getElementById('quotation-table').innerHTML = `<tr>
            <td>
                <div class="alert alert-warning" role="alert">
                    Aún no has agregado productos al cotizador.
                </div>
            </td>
        </tr>`
    }
}

// Actualización de la cantidad de productos
document
    .querySelectorAll('[data-quote-update]')
    .forEach(element => {
        element.addEventListener('change', function(){
            let product_id      = parseInt(this.getAttribute('data-quote-update'))
            let cant            = parseInt(this.value)
            let product_stored  = JSON.parse(localStorage.getItem('products'))

            product_stored  = product_stored.map( stored_product => {
                if( parseInt(stored_product.id) === product_id )
                {
                    stored_product.cant = cant
                }
                return stored_product
            })

            localStorage.setItem('products', JSON.stringify(product_stored))
        })
    })

// Quitar productos de la lista
document
    .querySelectorAll('[data-quote-remove]')
    .forEach(element => {
        element.addEventListener('click', function(){
            let product_id  = parseInt(this.getAttribute('data-quote-remove'))
            let tr_index    = parseInt(this.getAttribute('data-quote-index'))

            let product_stored  = JSON.parse(localStorage.getItem('products'))

            product_stored  = product_stored.filter( stored_product => {
                if( parseInt(stored_product.id) !== product_id )
                {
                    console.log(stored_product.id, product_id, parseInt(stored_product.id) !== product_id )
                    return stored_product
                }
            })

            document.querySelector('[data-quote-tr_index="'+tr_index+'"]')
                .remove()
            localStorage.setItem('products', JSON.stringify(product_stored))

            if( document.getElementById('quotation-table').querySelectorAll('tr').length === 0 )
            {
                location.reload()
            }
        })
    })