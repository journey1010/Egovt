$('.datepicker').datepicker({
    language: 'es'
});

$(document).on('click', '#searchSaldoBalance', function(){
    let estado = true;
    let starDate = $('date-start').val();
    let endDate = $('date-start').val();
    if(!esFechaYMD(starDate) && !esFechaYMD(endDate)){
        estado = false;
    }else {
        formData = {
            startDate: starDate,
            endDate: endDate
        };
    }

    if(estado){
        $.ajax({
            url: '/transparencia/saldos-balance/buscador-saldo-balance',
            method: 'POST',
            data: FormData, 
            dataType: 'json',
            beforeSend: function(){
                $('#searchSaldoBalance').html(`<span class="d-block btnText">Buscando</span>`);
                $('#spinner').show();
            },
            success: function(resp){   
                if (resp.status === 'success') {
                    $('.saldo-balance').html('');
                    if (resp.data !== null) {
                        generarElementosPaginados(resp.data);
                    }
                } else {
                    $('.saldo-balance').html('');
                }
                $('#searchSaldoBalance').html(`<span class="d-block btnText">Buscar</span>`);
                $('#paginador-saldo-balance').remove();
                $('#spinner').hide();
            },
            error: function(jqXHR, textStatus, errorThrown){
                $('#searchSaldoBalance').html(`<span class="d-block btnText">Buscar</span>`);
                $('#spinner').hide();
                $('#paginador-saldo-balance').remove();
            }
        });
    }
});

function esFechaYMD(valor) {
    if (typeof valor !== 'string') {
      return false;
    }
    var regex = /^\d{4}-\d{2}-\d{2}$/;
    if (!regex.test(valor)) {
      return false;
    }
    var fecha = new Date(valor);
    if (isNaN(fecha.getTime())) {
      return false;
    }
    var partes = valor.split('-');
    var año = parseInt(partes[0], 10);
    var mes = parseInt(partes[1], 10) - 1;
    var día = parseInt(partes[2], 10);
    if (fecha.getFullYear() !== año || fecha.getMonth() !== mes || fecha.getDate() !== día) {
      return false;
    }
    return true;
  }

function makeElement(data) {
    html = [];
    for (attr in data) {
        let fecha = new Date(attr.load_date);
        let opciones = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        };
        let fechaFormateada = fecha.toLocaleDateString('es-ES', opciones);
        html.push(`
                <div class="card p-3">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <span class="icnWrap pt-1 mr-3" style="font-size: 20px">
                                <i class="fas fa-book"></i>
                            </span>
                            <div class="descrWrap">
                                <h5 class="fwSemiBold">
                                    <a href="https://regionloreto.gob.pe/files/presupuesto/${attr.pathfile}" class="card-title">${attr.title}</a>
                                <h5>            
                                <strong class="d-block fileSize font-weight-normal card-text">${fechaFormateada}</strong>
                            </div>           
                        </div>
                        <a class="btn btn-outline light btnAlerDark btnNoOver btn-sm">Ver Documento</a>
                    </div>
                </div>';
        `);
    }
    generarPaginador(html);
}
  
function generarPaginador(data) {
    $('.saldo-balance').pagination({
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