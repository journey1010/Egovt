
$('.enlace').click(function(event) {
    event.preventDefault();
    var destino = $(this).attr('href');
    window.location.href = destino;
});

$(document).ready(function() {
    let url = window.location.href;

    $('li[name="panel"]').each(function() {
        if (url.includes($(this).find('a').attr('href'))) {
            $('li[name="panel"]').removeClass('active');
            $(this).addClass('active');
        }
    });
});

$(document).on('click', '#buscar', searchObra);

function searchObra() {
    let formData = {
        año: $('#año option:selected').val(),
        tipo: $('#tipo option:selected').val(),
        palabra: $('#palabra').val()
    }
    $.ajax({
        url: '/transparencia/proyecto-de-inversion-publica/filtros',
        method: 'POST',
        data: formData,
        beforeSend: function() {
            $('#spinner').show();
        },
        success: function(data) {
            $('#spinner').hide();
            try {
                let jsonData = JSON.parse(data);
                $('#resultados').html(jsonData.error);
            } catch (e) {
                $('#resultados').html(data);
                datable();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#spinner').hide();
        }
    });
}

function datable() {
    const table = $('#resultadosBusquedaObras').DataTable({
        stateSave: true,
        paging: true,
        searching: false,
        ordering: true,
        info: false,
        pagingType: "simple_numbers",
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            paginate: {
                first: 'Primera',
                last: 'Última',
                next: 'Siguiente',
                previous: 'Anterior'
            }
        }
    });
}