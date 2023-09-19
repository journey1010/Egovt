$('.datepicker').datepicker({
    language: 'es'
});
$(document).ready(function() {
    var table = $('#tabla').DataTable({
        stateSave: true,
        paging: false,
        searching: false,
        ordering: false,
        info: false
    });
    table.columns([7]).visible(false);

    $('#tabla tbody').on('click', '.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    function format(rowData) {
        data = `
            <div >
                <p style=" margin-bottom: 0px; overflow-wrap: anywhere"><strong>Motivo:</strong> <br> ${rowData[7]}</p>
            </div>
            `;
        return data;
    }
});
$(document).on('click', '#btnFecha', function() {
    fecha = $('.date-visita').val();
    if (fecha !== '') {
        $.ajax({
            url: '/transparencia/visitas-nuevas/post',
            method: 'POST',
            data: {
                fecha: fecha
            },
            success: function(data) {
                try {
                    let jsonData = JSON.parse(data);
                    $('#rowChildDatatable').html();
                    $('.table-responsive').html(jsonData.error);
                } catch (e) {
                    $('#rowChildDatatable').html();
                    $('.table-responsive').html(data);
                    filaSecundaria();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(`Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`);
            }
        });
    }

    function filaSecundaria() {
        var table = $('#tabla').DataTable({
            lengthChange: false,
            stateSave: true,
            searching: false,
            ordering: false,
            info: false,
            pagingType: "simple_numbers",
            language: {
                paginate: {
                    first: 'Primera',
                    last: 'Última',
                    next: 'Siguiente',
                    previous: 'Anterior'
                }
            }
        });
    }
});