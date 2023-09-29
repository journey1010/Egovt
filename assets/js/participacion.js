$('.datepicker').datepicker({
    language: 'es',
    defaultViewDate: { year: new Date().getFullYear(), month: new Date().getMonth(), day: new Date().getDate() }
});

let button = document.getElementById('searchParticipaciónCiudadana');
button.addEventListener('click', () => {
    let starDate = $('.date-start').val();
    let endDate = $('.date-end').val();
    let typeDoc =  $('#typeDoc').val();
    let formData = {
        startDate: starDate,
        endDate: endDate,
        typeDoc: typeDoc
    };

    $.ajax({
        url: '/transparencia/participacion-ciudadana/buscador-participacion',
        method: 'POST',
        data: formData, 
        dataType: 'json',
        beforeSend: function(){
            $('#searchParticipaciónCiudadana').html(`<span class="d-block btnText">Buscar</span>`);
        },
        success: function(resp){   
            if (resp.status === 'success') {
                $('.participacion-ciudadana').html('');
                if (resp.data !== null) {
                    makeElement(resp.data);
                }
            } else {
                $('.participacion-ciudadana').html('<h4 class="mt-3 text-center">Sin datos :(</h4>');
            }
            $('#searchSaldoBalance').html(`<span class="d-block btnText">Buscando</span>`);
            $('.paginador-participacion-ciudadana').remove();
        },
        error: function(jqXHR, textStatus, errorThrown){
            $('#searchSaldoBalance').html(`<span class="d-block btnText">Buscando</span>`);
            $('.paginador-participacion-ciudadana').remove();
        }
    });
});

function makeElement(data) {
    html = [];
    for (item in data){
        const row = data[item];
        const loadDate = row.load_date;
        const fecha = new Date(loadDate);
        const opciones = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        };

        const fechaFormateada = fecha.toLocaleDateString('es-ES', opciones);
        const partialPath = fecha.toLocaleDateString('en-US', { year: 'numeric', month: '2-digit' }) + '/';
        const files = JSON.parse(row.files);
        const div = `
            <div class="card p-0">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="descrWrap">
                            <h5 class="fwSemiBold card-title">${row.title}</h5>
                            <p class="d-block fileSize text-dark card-text">${fechaFormateada}</p>
                            <strong class="d-block fileSize font-weight-normal card-text">${row.descriptions}</strong>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="descrWrap">
                            <p class="d-block fileSize text-dark card-text mb-1"> <i class="fal fa-file-pdf"></i> Archivos:</p>
                            <div class="row-cols-1">
                                ${files.map(file => `
                                    <a href="https://regionloreto.gob.pe/files/transparencia/participacion-ciudadana/${partialPath}${file.file}">${file.namefile}</a>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        html.push(div);
    }
    generarPaginador(html);
}

function generarPaginador(data) {
    $('.participacion-container').pagination({
        dataSource: data,
        pageSize: 10,
        ulClassName: 'pagination justify-content-center pt-2',
        callback: function(data, pagination) {
            $('.participacion-ciudadana').html(data);
            $('.paginationjs li').addClass('page-item');
            $('.paginationjs a').addClass('page-link');
        },

    });
}
