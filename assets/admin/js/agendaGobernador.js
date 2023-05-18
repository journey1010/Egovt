import { Toast } from './Toast.js';

$(document).ready(select2);
function select2() {
  $(".select2").select2({
    closeOnSelect: true,
  });
}


$(document).on('submit', '#registrarAgenda', function(event){
    event.preventDefault();
    if ($('#fechaAgenda').val() == '' || $('#temaAgenda').val() == ''){
        Toast.fire({
            icon: 'warning',
            title: 'Por favor, tiene que completar los campos obligatorios.'
        });
    } else {
        let formData = {
            fecha: $('#fechaAgenda').val(),
            hora: $('#horaAgenda').val(),
            organizador: $('#organizaAgenda').val(),
            lugar: $('#lugarAgenda').val(),
            participantes: $('#participantesAgenda').val(),
            tema: $('#temaAgenda').val(),
            actividad: $('#descripcionAgenda').val()
        }

        $.ajax({
            url: '/administrador/agenda/registrar-agenda',
            method: 'POST',
            data: formData,
            beforeSend: function(){
                $('.btn.btn-primary.mt-2').text('Enviado');
            },
            success: function (response){
                let resp = JSON.parse(response);
                if (resp.status === 'success'){
                    Toast.fire({
                        icon: 'success',
                        title: resp.message
                    });
                    $('#fechaAgenda').val() = '';
                    $('#horaAgenda').val()='';
                    $('#organizaAgenda').val()='';
                    $('#lugarAgenda').val()='';
                    $('#participantesAgenda').val()='';
                    $('#temaAgenda').val()='';
                    $('#descripcionAgenda').val()='';
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: resp.message
                    });
                }
                $('.btn.btn-primary.mt-2').text('Guardar Agenda');
            },
            error: function(jqXHR, textStatus, errorThrown){
                Toast.fire({
                    icon: 'error',
                    tittle:`Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
                    background: '#ff0000'
                });
            }
        });
    }
});

$(document).on('click', '#limpiarAgendaFiltro', function(){
    $('#orderByAgenda').selectedIndex = 0;
    $('#fechaAgendaActualizar').value = '';
    $('#orderByAgenda').select2('destroy');
    $('.select2').select2({
        closeOnselect: true,
    });
});

$(document).on('click', '#aplicarFiltroAgenda', searchAgenda);
function searchAgenda(){
    if($('#fechaAgenda').val() === ''){
        Toast.fire({
            icon: 'warning',
            title: 'Por favor, ingrese una palabra una fecha para iniciar una búsqueda.'
        });
    } else {
        let formData = {
            fecha: $('#fechaAgendaActualizar').val(),
            order: $('#orderByAgenda').val()
        }
        $.ajax({
            url: '/administrador/agenda/buscar-agenda',
            method: 'POST',
            data: formData,
            beforeSend: function(){
                $('#spinnerAgenda').show();
            },
            success:  function (data){
                let resp = JSON.parse(data);
                if(resp.status === 'success'){
                    $('#respuestaAgenda').html(data);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: resp.message
                    });
                    $('#spinnerAgenda').hide();
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                $('#spinnerAgenda').hide();
                Toast.fire({
                    icon: 'error',
                    title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
                    background: '#ff0000'
                });
            }
        });
    }
}

$(document).on('click', '.edit-icon-agenda', function () {
    let row = $(this).closest("tr");
    let id = row.find("td:eq(0)").text();
    let titulo = row.find("td:eq(1)").text();
    let descripcion = row.find("td:eq(2)").text();
    let tipo = row.find("td:eq(3)").text();
    let fecha = row.find("td:eq(4)").text();
  
    row.find(".edit-icon").hide();
    row.find(".cancel-icon").show();
  
    Swal.fire({
      width: 'auto',
      heightAuto: false,
      html: formToUpdate(id, titulo, descripcion, tipo, fecha),
      showCancelButton: true,
      confirmButtonText: 'Guardar',
      cancelButtonText: 'Cancelar',
      preConfirm: () => {
        row.find(".cancel-icon").show();
        actualizarObra();
      }, 
      willClose: function() {
        row.find(".cancel-icon").hide();
        row.find(".edit-icon").show();
      }
    });
  });