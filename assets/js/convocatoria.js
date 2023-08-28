$(document).on('click', '#buscarConvocatoria', BuscarConvocatoria);
function BuscarConvocatoria() {
    let formData = {
        fechaDesde: $('#dp4').val(),
        fechaHasta: $('#dp1').val(),
        palabra: $('#palabra').val()
    };
    $.ajax({
        url: '/transparencia/convocatorias-de-trabajo/buscar',
        method: 'POST',
        data: formData,
        beforeSend: function() {
            $('#spinner').show();
        },
        success: function(response) {
            $('#spinner').hide();
            let resp = JSON.parse(response);
            if (resp.status === 'success') {
                $('.convocatorias').html('<div class="datos"></div>');
                if (resp.data !== null) {
                    generarElementosPaginados(resp.data);
                }
            } else {
                $('.convocatorias').html('');
            }
        }
    });
}

function generarElementosPaginados(data) {
    $('.convocatorias').pagination({
        dataSource: data,
        pageSize: 12,
        ulClassName: 'pagination justify-content-center pt-2',
        callback: function(data, pagination) {
            $('.datos').html(data);
            $('.paginationjs li').addClass('page-item');
            $('.paginationjs a').addClass('page-link');
        },

    });
}