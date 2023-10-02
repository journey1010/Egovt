$('.datepicker').datepicker({
    language: 'es'
});

let button = document.getElementById('searchSaldoBalance');
button.addEventListener('click', () => {
    let starDate = $('.date-start').val();
    let formData = {
        startDate: starDate,
    };

    $.ajax({
        url: '/transparencia/saldos-balance/buscador-saldo-balance',
        method: 'POST',
        data: formData, 
        dataType: 'json',
        beforeSend: function(){
            $('#searchSaldoBalance').html(`<i class="icomoon-search"> Buscando</span></i>`);
            $('#spinner').show();
        },
        success: function(resp){   
            if (resp.status === 'success') {
                $('.saldo-balance').html('');
                if (resp.data !== null) {
                    makeElement(resp.data);
                }
            } else {
                $('.saldo-balance').html('');
            }
            $('#searchSaldoBalance').html(`<i class="icomoon-search"><span class="sr-only">Buscar</span></i>`);
            $('.paginador-saldo-balance').remove();
            $('#spinner').hide();
        },
        error: function(jqXHR, textStatus, errorThrown){
            $('#searchSaldoBalance').html(`<i class="icomoon-search"><span class="sr-only">Buscar</span></i>`);
            $('#spinner').hide();
            $('.paginador-saldo-balance').remove();
        }
    });
}); 

function makeElement(data) {
    html = [];
    for (attr in data) {
        const loadDate = data[attr].load_date;
        const fecha = new Date(loadDate);
        const opciones = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        };
        const fechaFormateada = fecha.toLocaleDateString('es-ES', opciones);
        html.push(`
                <div class="card p-3">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <span class="icnWrap pt-1 mr-3" style="font-size: 20px">
                                <i class="fas fa-book"></i>
                            </span>
                            <div class="descrWrap">
                                <h5 class="fwSemiBold">
                                    <a href="https://regionloreto.gob.pe/files/presupuesto/${data[attr].pathfile}" class="card-title">${data[attr].title}</a>
                                <h5>            
                                <strong class="d-block fileSize font-weight-normal card-text">${fechaFormateada}</strong>
                            </div>           
                        </div>
                        <a class="btn btn-outline light btnAlerDark btnNoOver btn-sm">Ver Documento</a>
                    </div>
                </div>
        `);
    }
    generarPaginador(html);
}
  
function generarPaginador(data) {
    $('.saldo-container').pagination({
        dataSource: data,
        pageSize: 10,
        ulClassName: 'pagination justify-content-center pt-2',
        callback: function(data, pagination) {
            $('.saldo-balance').html(data);
            $('.paginationjs li').addClass('page-item');
            $('.paginationjs a').addClass('page-link');
        },

    });
}