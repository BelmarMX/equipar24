import Swal from "sweetalert2";
const axios = require('axios').default
const instance = axios.create({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

document.querySelectorAll('.blog__view__link')
    .forEach(element => {
        element.addEventListener('click', function(){
            document.getElementById('load8').removeAttribute('hidden')
            document.getElementById('porfolio_modal')
                .querySelector('.modal-dialog')
                .innerHTML = ""

            instance.get(this.getAttribute('href'))
                .then(({data}) => {
                    document.getElementById('porfolio_modal')
                        .querySelector('.modal-dialog')
                        .innerHTML = data

                    document.getElementById('load8').setAttribute('hidden', 'hidden')
                })
                .catch(error => {
                    console.error(error)
                    document.getElementById('load8').setAttribute('hidden', 'hidden')

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
                        icon: 'error',
                        title: 'Lo sentimos un error impidió abrir el proyecto'
                    })
                })
        })
    })