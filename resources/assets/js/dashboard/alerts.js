import swal     from "sweetalert2";
import Swal from "sweetalert2";

class Alert
{
    success(message, title = 'Tarea completada exitosamente')
    {
        swal.fire({
                icon: 'success'
            ,   title: title
            ,   text: message
        })
    }

    success_callback(message, title, callback = () => {}, timer = 1500)
    {
        swal.fire({
                icon: 'success'
            ,   title: title
            ,   text: message
            ,   timer: timer
            ,   timerProgressBar: true,
        })
            .then( t => callback() )
    }

    warning(message, title = 'Es necesario verificar la información')
    {
        swal.fire({
                icon: 'warning'
            ,   title: title
            ,   text: message
        })
    }

    error(message, title = 'Ocurrió un error inesperado')
    {
        swal.fire({
                icon: 'error'
            ,   title: title
            ,   text: message
        })
    }

    info(message, title = 'Mensaje importante')
    {
        swal.fire({
                icon: 'info'
            ,   title: title
            ,   text: message
        })
    }

    confirm(message, callback = () => {}, ask="¿Estás seguro de realizar esta acción?")
    {
        swal.fire({
                icon: 'warning'
            ,   title: ask
            ,   html: message
            ,   showCancelButton: true
            ,   confirmButtonColor: '#10B981'
            ,   cancelButtonColor: '#F59E0B'
            ,   confirmButtonText: '¡Sí, continuar!'
            ,   cancelButtonText: 'Prefiero revisar'
        }).then((result) => {
            if (result.isConfirmed)
            {
                callback(result)
            }
        })
    }
    confirm_todo(title, message, callback = () => {}, icon = 'info', confirm_text = 'Proceder', cancel_text = 'Cancelar')
    {
        swal.fire({
                icon: icon
            ,   title: title
            ,   html: message
            ,   showCancelButton: true
            ,   confirmButtonColor: '#10B981'
            ,   cancelButtonColor: '#F59E0B'
            ,   confirmButtonText: confirm_text
            ,   cancelButtonText: cancel_text
            ,   reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed)
            {
                callback()
            }
        })
    }

    ligthbox( img_url, title = 'Vista Previa' )
    {
        swal.fire({
                icon: 'info'
            ,   title: title
            ,   html: `<img src="${img_url}" style="margin: 0 auto;" alt="${title}">`
            ,	showCloseButton: true
            ,	showConfirmButton: false
            ,   width: '80vw'
        })
    }

    flash(message, ms = 2000)
    {
        swal.fire({
            position: 'center',
            icon: 'info',
            title: 'Importante',
            html: message,
            showConfirmButton: false,
            timer: ms,
            timerProgressBar: true,
            customClass: 'z-40'
        })
    }

    html(message, title, wide)
    {
        let customClass =
        swal.fire({
            title:              '<strong>'+title+'</strong>',
            html:               message,
            showCloseButton:    true,
            showCancelButton:   false,
            showConfirmButton:  false,
            focusConfirm:       false,
            customClass:        wide ? 'w-screen-80' : ''
        })
    }

    toast(title, type = 'success', timer = 4000)
    {
        const Toast = swal.mixin({
            toast:              true,
            position:           'top',
            showConfirmButton:  false,
            timer:              timer,
            timerProgressBar:   true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', swal.stopTimer)
                toast.addEventListener('mouseleave', swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: type,
            title: title
        })
    }
}

export default new Alert()
