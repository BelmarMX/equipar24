import axios from "axios";

$(document).ready(function() {
    $('#state_id').select2({
        language: "es"
    });

    $('#state_id').on('change', function() {
        let state_id = $(this).val();
        axios.post('/contacto/cities'
            ,   {
                state_id: state_id
            })
            .then(({data}) => {
                $('#city_id').empty()
                $('#city_id').append(`<option selected>Por favor selecciona una ciudad</option>`)
                data.forEach(city => {
                    $('#city_id').append(`<option value="${city.id}">${city.name}</option>`)
                })
                $('#city_id').select2({
                    language: "es"
                });
            })
            .catch(error => {
                console.error('Cities Error', error)
            })
    })

    $('#email').on('focusout', function(e) {
        axios.post('/contacto/find', {
            email: $(this).val()
        })
            .then(({data}) => {
                if( data)
                {
                    $('#uuid').val(data.uuid)
                    $('#name').val(data.name)
                    $('#phone').val(data.phone)
                    $('#company').val(data.company)
                    $('#state_id').val(data.state_id).change()
                }
            })
            .catch(e => console.error(e))
    })
})
