$(datepicker).();

$(document).on('click', '#buscarAgenda', BuscarAgenda);
function BuscarAgenda(){
    let formData = {
        fechaDesde : $('#dp4').val(),
        fechaHasta : $('#dp1').val(),
        palabra: $('#palabra').val()
    };
    $.ajax({
        url: '/transparencia/actividades-oficiales/buscar',
        method: 'POST',
        data: formData,
        beforeSend: function(){
            $('#spinner').hide();
        },
        success: function(response){
            let resp = JSON.parse(response);
            if(resp.status === 'success'){
                $('.agendas').html('<div class="row datos"></div>');
                if( resp.data !== null){
                    generarElementosPaginados(resp.data);
                } 
            } else {
                $('.agendas').html('');
            }
        }
    });
}
function generarElementosPaginados(data) {
    $('.agendas').pagination({
        dataSource: data,
        pageSize: 10,
        ulClassName: 'pagination justify-content-center pt-2',
        callback: function(data, pagination) {
            $('.datos').append(data.join(''));
            $('.paginationjs li').addClass('page-item');
            $('.paginationjs a').addClass('page-link');
        },

    });
}