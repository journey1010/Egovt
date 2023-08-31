import { Toast } from './Toast.js';
let formularioIndex = 1;

$(document).on('click', '#enviarForm', function(event){
    event.preventDefault();
    let formularios = $('.form-agenda');
    let temaRequerido = true;
    let fechaRequerido = true;
    formularios.each(function(){
        let formulario = $(this);
        let camposRequeridos1 = formulario.find('[id^="temaAgenda"]');
        camposRequeridos1.each(function(){
            let campo = $(this);
            if(campo.val() === ''){
                temaRequerido = false;
                campo.css('border-color', 'red');
            }
        });

        let camposRequeridos2 = formulario.find('[id^="fechaAgenda"]');
        camposRequeridos2.each(function(){
            let campo2 = $(this);
            if(campo2.val() === ''){
                fechaRequerido = false;
                campo2.css('border-color', 'red');
            }
        });

    });

    if( temaRequerido === true && fechaRequerido === true){
        let Forms = $('.contenedorFormularios .form-agenda');
        let dataForms = [];
        Forms.each(function(){
            let formulario = $(this);
            let datos = {};
            formulario.serializeArray().forEach(function(item) {
                datos[item.name] = item.value;
              });
            dataForms.push(datos);
        });
       
        $.ajax({
            url: '/administrador/agenda/registrar-agenda',
            method: 'POST',
            data: {dataForms : dataForms},
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
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: resp.message
                    });
                }
                $('.btn.btn-primary.mt-2').text('Guardar Agenda');
                setInterval( function(){
                    location.reload();
                }, 2000);
            },
            error: function(jqXHR, textStatus, errorThrown){
                Toast.fire({
                    icon: 'error',
                    tittle:`Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
                    background: '#ff0000'
                });
            }
        });
    } else {
        Toast.fire({
            icon: 'warning',
            title: 'Verifique los campos obligatorios. Los campos obligatorios deben estar completos.'
        })
    }
});

$(document).on('click', '.insert-agenda', insertForm);

function insertForm(){
    let formularioOriginal = $('.registrarAgenda');
    let nuevoFormulario = formularioOriginal.clone();
    
    nuevoFormulario.removeClass('registrarAgenda');
    nuevoFormulario.find('textarea').val('');
    nuevoFormulario.appendTo('.contenedorFormularios');
    nuevoFormulario.append(`<div class="m-2 d-flex justify-content-end"><a class="btn btn-danger btn-sm eliminar-form" alt="Eliminar" title="Eliminar formulario"><i class="fas fa-trash-alt"></i></a></div>`);
    
    formularioIndex++; 
}

$(document).on('click', '.eliminar-form', function(){
    $(this).closest('form').remove();
});

$(document).on('click', '#limpiarAgendaFiltro', limpiarFiltroAgenda);
function limpiarFiltroAgenda(){
    $('#orderByAgenda').val('');
    $('#fechaAgendaActualizar').val('');
    $('#orderByAgenda').select2('destroy');
    $('.select2').select2({
        closeOnselect: true,
    });
}

$(document).on('click', '#aplicarFiltroAgenda', searchAgenda);
function searchAgenda(){
    if($('#fechaAgenda').val() === ''){
        Toast.fire({
            icon: 'warning',
            title: 'Por favor, ingrese una fecha para iniciar una búsqueda.'
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
                    $('#respuestaAgenda').html(resp.data);
                    $('#spinnerAgenda').hide()
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
    let fecha = row.find("td:eq(1)").text();
    let hora = row.find("td:eq(2)").text();
    let actividad = row.find("td:eq(4)").text();
    let tema = row.find("td:eq(3)").text();
    let organiza = row.find("td:eq(5)").text();
    let lugar = row.find("td:eq(6)").text();
    let participante = row.find("td:eq(7)").text();
  
    Swal.fire({
      width: 'auto',
      heightAuto: false,
      html: formToUpdate(id, fecha, hora, actividad, tema, organiza, lugar, participante),
      showCancelButton: true,
      confirmButtonText: 'Guardar',
      cancelButtonText: 'Cancelar',
      preConfirm: () => {
        actualizarAgenda();
      }, 
    });
});

function formToUpdate(id, fecha, hora, actividad, tema, organiza, lugar, participante) {
    let htmlContent = `
    <div class="card-header text-white" style="background-color:#1291ab;">
        <h3 class="card-title">Actualizar Agenda de Gobernación</h3>
    </div>
    <form id="registrarAgenda">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 campoOpcional">
                    <label for="temaAgenda">Tema de Agenda (Obligatorio)</label>
                    <input type="text" class="form-control" id="idAgenda" value="${id}" style="display: none;">
                    <input type="text" class="form-control" id="temaAgenda" value="${tema}">
                </div>
                <div class="col-md-4">
                    <label for="fechaAgenga">Fecha de Agenda (Obligatorio)</label>
                    <input type="date" class="form-control" id="fechaAgenda" value="${fecha}">
                </div>
                <div class="col-md-4 campoOpcional">
                    <label for="horaAgenda">Hora de Agenda</label>
                    <input type="time" class="form-control" id="horaAgenda" value="${hora}">
                </div>
                <div class="col-md-4 campoOpcional">
                    <label for="organizaAgenda">Organizador</label>
                    <input type="text" class="form-control" id="organizaAgenda" placeholder="¿Quién organiza?" value="${organiza}">
                </div>
                <div class="col-md-4 campoOpcional">
                    <label for="lugarAgenda">Lugar</label>
                    <input type="text" class="form-control" id="lugarAgenda" placeholder="¿Dónde se realizará?" value="${lugar}">
                </div>
                <div class="col-md-4 campoOpcional">
                    <label for="participantesAgenda">Participantes</label>
                    <input type="text" class="form-control" id="participantesAgenda"  placeholder="¿Quién o Quiénes participan?" value="${participante}"> 
                </div>
                <div class="col-md-12 campoOpcional">
                    <label for="descripcion">Actividad de Agenda</label>
                    <textarea type="text" class="form-control text-content" id="descripcionAgenda" placeholder="Por favor, ingrese una descripción más detallada con respecto al tema de la agenda." style="min-height: 100px; max-width: 100%">${actividad}</textarea>
                </div>
            </div>
        </div>
    </form>
    `;
    return htmlContent;
}
  
function actualizarAgenda () {
    if ($('#fechaAgenda').val() ==='' || $('#temaAgenda').val() ==='' || $('#idAgenda').val()==='') {
        Toast.fire({
            icon: 'warning',
            title: 'Por favor, tiene que completar los campos obligatorios.'
        });
    }  else {
        let formData = {
            id: $('#idAgenda').val(),
            fecha: $('#fechaAgenda').val(),
            hora: $('#horaAgenda').val(),
            organizador: $('#organizaAgenda').val(),
            lugar: $('#lugarAgenda').val(),
            participantes: $('#participantesAgenda').val(),
            tema: $('#temaAgenda').val(),
            actividad: $('#descripcionAgenda').val()
        }

        $.ajax({
            url: '/administrador/agenda/actualizar-agenda',
            method: 'POST',
            data: formData,
            success: function (response){
                let resp = JSON.parse(response);
                if (resp.status === 'success'){
                    Toast.fire({
                        icon: 'success',
                        title: resp.message
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: resp.message
                    });
                }
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
}