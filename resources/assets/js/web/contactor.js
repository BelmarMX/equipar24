import axios from "axios";

$(document).ready(function() {
    $('#estado').select2({
        language: "es"
    });

    $('#estado').on('change', function() {
        let state_id = $(this).val();
        axios.post('/contacto/cities'
            ,   {
                state_id: state_id
            })
            .then(({data}) => {
                $('#ciudad').empty()
                $('#ciudad').append(`<option selected>Por favor selecciona una ciudad</option>`)
                data.forEach(city => {
                    $('#ciudad').append(`<option value="${city.id}">${city.name}</option>`)
                })
                $('#ciudad').select2({
                    language: "es"
                });
            })
            .catch(error => {
                console.error('Cities Error', error)
            })
    });
});
