import 'magicsuggest/magicsuggest-min'

$(function() {
    $('#autocomplete').magicSuggest({
        typeDelay: 3,
        data: '/productos/autocomplete',
        ajaxConfig: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        valueField: 'name',
        hideTrigger: true,
        highlight: true,
        useTabKey: true,
        matchCase: false,
        maxSelection: 1,
        maxSuggestions: 12,
        strictSuggest: false,
        maxSelectionRenderer: function()
        {
            return 'Presiona buscar'
        },
        minChars: 3,
        minCharsRenderer: function(v)
        {
            return 'Continua escribiendo';
        },
        noSuggestionText: 'Sin coincidencias',
        selectionRenderer: function(data)
        {
            if( !data ){ return; }
            return data.title+' | '+data.brand+' | '+data.category+' | '+data.subcategory
        },
        renderer: function(data)
        {
            let discount    = data.discount != 0
                ? `<small class="bg-danger text-white p-1 ms-1">${data.discount}%</small>`
                : ''
            let con_flete   = data.con_flete
                ? `<span class="badge bg-danger text-white">¡Flete incluido!</span>`
                : ''
            return `
                <div class="autocomplete-box">
                    <div class="autocomplete-image">
                        <img src="${data.image}">
                    </div>
                    <div class="autocomplete-info">
                        <span class="autocomplete-title">${data.title}</span>
                        <span class="autocomplete-cats">${data.category} / ${data.subcategory}</span>
                        ${con_flete}
                        <div class="autocomplete-additional">
                            <span class="autocomplete-brand">${data.brand}</span>
                            <span class="autocomplete-price">$ ${data.price}${discount}</span>
                        </div>
                    </div>
                </div>
            `
        }
    })
})

$(document).on('click', '.ms-res-item', function(ev){
    document.getElementById('load8')
        .removeAttribute('hidden')

    let info = JSON.parse($(this).attr('data-json'))
    if( info )
    {
        return location.href = info.route
    }
})

$(document).on('click', '#do-search', function(e) {
    e.preventDefault()
    document.getElementById('load8')
        .removeAttribute('hidden')

    let form    = $(this).parent('form')
    let input   = $(document).find('input[name="search[]"]').val()
    let url     = form.attr('action').replace('__search_term__', encodeURI(input))
    location.href = url
})

$(document).on('keydown', '.ms-sel-ctn > input[type="text"]', function(event){
    if(event.which === 13 || event.keyCode === 13)
    {
        $('#do-search').click()
    }
})
